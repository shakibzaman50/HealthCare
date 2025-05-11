<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\InvoiceController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\cartTotal;
use function App\Helpers\handleOrderStatusChangeLog;

class OrderController extends Controller
{
    public function orderDone(Request $request)
    {
        $carts = session()->get('cart', []);

        $cartTotal = cartTotal();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        // Begin transaction to ensure all updates happen atomically
        DB::beginTransaction();
        // Check Product Available or not in stock 
        try {
            // Check Customer 
            $checkCustomer = (new InvoiceController())->checkCustomer($request);
            // Store supplier invoice details
            $invoice = Order::create([
                'customer_id' => $checkCustomer->id,
                'address' => $request->address,
                'invoice_id' => now()->timestamp,
                'invoice_type' => config('app.transaction_payable_type.customer'),
                'date' => now(),
                'store_id' => $request->store_id ?? config('app.store_type.office'),
                'total' => (int) $cartTotal['totalPrice'],
                'discount' => (int) $request->discount ?? 0,
                'payable_amount' =>  (int) $cartTotal['totalPrice'] + (int) $request->deliveryOption,
                'paid' => (int) $request->paid ?? 0,
                'due' => (int) $cartTotal['totalPrice'] + (int) $request->deliveryOption,
                'status_id' => $request->status_id ?? 1,
                'note' => $request->note,
                'delivery_company_id' => $request->delivery_company_id ?? 3,
                'delivery_charge' => (int) $request->deliveryOption ?? 120,
                'created_by' => $checkCustomer->id,
            ]);
            info('Create Customer Invoice ', [$invoice]);
            // Loop through each product and process the invoice details
            foreach ($carts as $product) {

                // Store each product details in the SupplierInvoiceProduct
                $invoiceProductStore = OrderDetail::create([
                    'order_id' => $invoice->id,
                    'product_id' => $product['id'],
                    'quantity' => (int)$product['quantity'],
                    'unit_price' => (int) $product['price'],
                    'total_price' => (int) $product['quantity'] * (int) $product['price'],
                ]);
                info('invoiceProductStore', [$invoiceProductStore]);
            }



            $status_log =  handleOrderStatusChangeLog($invoice->id, 1,  $checkCustomer->id);
            if ($status_log['status'] != 200) {
                DB::rollBack();
                return ['status' => 400, 'message' => 'Error saving order Status Log: '];
            }
            // Clear Cache 
            session()->forget('cart');

            // Commit the transaction if everything is successful
            DB::commit();
            return ['status' => 200, 'message' => 'Stock for Sell'];

            return redirect()->route('supplier.invoice.index')->with('success', 'Invoice created successfully!');
        } catch (\Exception $e) {
            info('Error while store wholesaler order', [$e]);
            // Rollback the transaction in case of errors
            DB::rollBack();
            return ['status' => 405, 'message' => 'error' . $e->getMessage()];

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

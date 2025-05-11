<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request)
    {
        $withdraws =  Withdraw::where('customer_id',auth()->guard('customer')->id())->paginate(10);

        return view('customer.withdraw.index',compact('withdraws'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('customer.withdraw.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|max:'.auth()->guard('customer')->user()->balance,
        ],[
            'amount' => 'Not enough balance'
        ]);
        Withdraw::create([
            'customer_id' => auth()->guard('customer')->id(),
            'amount' => $request->amount,
            'status' => 'pending',
        ]);
        auth()->guard('customer')->user()->update([
            'balance' => auth()->guard('customer')->user()->balance - $request->amount,
        ]);
        return redirect()->route('customer.withdraw.index')->with('success', 'Withdraw request submitted successfully.');
    }
}

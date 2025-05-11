<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#wholeSaleModal_{{ $user->id }}">
    Payment
</button>

<!-- Large Modal -->
<div class="modal fade" id="wholeSaleModal_{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Make Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mx-auto p-4">
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ config('app.transaction_payable_type.wholesaler') }}"
                            name="payable_type">
                        <input type="hidden" name="payable_id" value="{{ $user->id }}">
                        <input type="hidden" name="payment_type" value="credit">

                        <div class="mb-4">
                            <label for="amount" class="block text-gray-700">Amount</label>
                            <input type="number" name="amount" id="amount"
                                class="form-input mt-1 block w-full form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="block text-gray-700">Payment Method</label>
                            <select name="payment_method" id="payment_method"
                                class="form-select mt-1 block w-full form-control">
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="note" class="block text-gray-700">Note</label>
                            <textarea name="note" id="note"
                                class="form-textarea mt-1 block w-full form-control"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="invoice_id" class="block text-gray-700">Invoice ID (Optional)</label>
                            <input type="text" name="invoice_id" id="invoice_id"
                                class="form-input mt-1 block w-full form-control">
                        </div>
                        <button type="submit" class=" px-4 py-2 rounded">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
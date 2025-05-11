<div class="mb-3 row">
    <label for="category_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Category</label>
    <div class="col-lg-10 col-xl-9">
        <select class="select2 form-select{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="category_id"
            name="category_id">
            <option value="" style="display: none;" {{ old('category_id', optional($expense)->category_id ?: '') == '' ?
                'selected' : '' }} disabled selected>Select category</option>
            @foreach ($Expensecategories as $key => $Expensecategory)
            <option value="{{ $key }}" {{ old('category_id', optional($expense)->category_id) == $key ? 'selected' : ''
                }}>
                {{ $Expensecategory }}
            </option>
            @endforeach
        </select>

        {!! $errors->first('category_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="description" class="col-form-label text-lg-end col-lg-2 col-xl-3">Description</label>
    <div class="col-lg-10 col-xl-9">
        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description"
            id="description" minlength="1"
            maxlength="1000">{{ old('description', optional($expense)->description) }}</textarea>
        {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="amount" class="col-form-label text-lg-end col-lg-2 col-xl-3">Amount</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" type="text"
            id="amount" value="{{ old('amount', optional($expense)->amount) }}" minlength="1"
            placeholder="Enter amount here...">
        {!! $errors->first('amount', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="received_by" class="col-form-label text-lg-end col-lg-2 col-xl-3">Received By</label>
    <div class="col-lg-10 col-xl-9">
        <select class="select2 form-select{{ $errors->has('received_by') ? ' is-invalid' : '' }}" id="received_by"
            name="received_by">
            <option value="" style="display: none;" {{ old('received_by', optional($expense)->received_by ?: '') == '' ?
                'selected' : '' }} disabled selected>Select received by</option>
            @foreach ($receivedBies as $key => $receivedBy)
            <option value="{{ $key }}" {{ old('received_by', optional($expense)->received_by) == $key ? 'selected' : ''
                }}>
                {{ $receivedBy }}
            </option>
            @endforeach
        </select>

        {!! $errors->first('received_by', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="payment_date" class="col-form-label text-lg-end col-lg-2 col-xl-3">Payment Date</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('payment_date') ? ' is-invalid' : '' }}" name="payment_date"
            type="date" id="payment_date" value="{{ old('payment_date', optional($expense)->payment_date) }}"
            placeholder="Enter payment date here...">
        {!! $errors->first('payment_date', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="Invoice" class="col-form-label text-lg-end col-lg-2 col-xl-3">Invoice</label>
    <div class="col-lg-10 col-xl-9">
        <div class="mb-3">
            <input class="form-control{{ $errors->has('Invoice') ? ' is-invalid' : '' }}" type="file" name="Invoice"
                id="Invoice" class="">
        </div>

        @if (isset($expense->Invoice) && !empty($expense->Invoice))

        <div class="input-group mb-3">
            <div class="form-check">
                <input type="checkbox" name="custom_delete_Invoice" id="custom_delete_Invoice"
                    class="form-check-input custom-delete-file" value="1" {{ old('custom_delete_Invoice', '0' )=='1'
                    ? 'checked' : '' }}>
            </div>
            <label class="form-check-label" for="custom_delete_Invoice"> Delete {{ $expense->Invoice }}</label>
        </div>

        @endif

        {!! $errors->first('Invoice', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
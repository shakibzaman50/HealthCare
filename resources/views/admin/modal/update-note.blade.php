<div class="modal-header">
    <h4>Customer Note</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="mediumBody">
    <div>
        <form method="POST" action="{{ route('admin.update.customer.note') }}">
            @csrf
            <div class="form-group">
                <input type="hidden" value="{{ $customer->id }}" name="customerId">
                <textarea name="note" class="form-control">{{$customer->note}}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update Note</button>
        </form>
    </div>
</div>
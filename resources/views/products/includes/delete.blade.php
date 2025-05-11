<!-- Bottom Offcanvas -->
<div class="mt-4">
    <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#productDeleteButton-{{$id}}" aria-controls="productDeleteButton">Delete</button>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="productDeleteButton-{{$id}}"
        aria-labelledby="productDeleteButtonLabel">
        <div class="offcanvas-header">
            <h5 id="productDeleteButtonLabel" class="offcanvas-title">Delete</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('products.destroy', $id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger flex-fill">Delete</button>
            </form>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>
</div>
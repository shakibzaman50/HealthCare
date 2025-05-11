<!-- Bottom Offcanvas -->
<div class="mt-4">
    <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#wholesalerDeleteButton_{{$id}}" aria-controls="wholesalerDeleteButton">Delete</button>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="wholesalerDeleteButton_{{$id}}"
        aria-labelledby="roleDeleteButtonLabel">
        <div class="offcanvas-header">
            <h5 id="roleDeleteButtonLabel" class="offcanvas-title">Delete User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('wholesalers.destroy', $id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger flex-fill">Delete</button>
            </form>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>
</div>
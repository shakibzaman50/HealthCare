<!-- Bottom Offcanvas -->
<div class="mt-4">
    <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoryDeleteButton"
        aria-controls="categoryDeleteButton">Delete</button>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="categoryDeleteButton"
        aria-labelledby="categoryDeleteButtonLabel">
        <div class="offcanvas-header">
            <h5 id="categoryDeleteButtonLabel" class="offcanvas-title">Delete</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('units.destroy', $id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger flex-fill">Delete</button>
            </form>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>
</div>
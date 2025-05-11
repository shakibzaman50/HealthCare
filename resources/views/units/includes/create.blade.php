<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unitCreateModal">
    Create Unit
</button>
<div class="modal fade" id="unitCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Create Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('units.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Abbreviation:</label>
                        <input type="text" name="abbreviation" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="conversion_rate">Conversion Rate:</label>
                        <div class="input-group">
                            <input type="number" step="0.0001" name="conversion_rate" class="form-control" required value="1">
                            <span class="input-group-text">base unit</span>
                        </div>
                        <small class="form-text text-muted">Enter how many base units (e.g., kg) equals 1 of this unit</small>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_base_unit" class="form-check-input" id="is_base_unit">
                        <label class="form-check-label" for="is_base_unit">Is Base Unit?</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
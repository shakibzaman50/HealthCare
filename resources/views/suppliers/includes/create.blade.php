<div class="mt-4">
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd"
        aria-controls="offcanvasEnd">Create Suppliers</button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">Create New Supplier
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body my-auto mx-0 flex-grow-0">
            <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('suppliers.includes.form')
            </form>
        </div>
    </div>
</div>
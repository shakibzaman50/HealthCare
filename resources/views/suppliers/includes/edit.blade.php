<div class="mt-4">
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#editRole-{{ $user->id }}"
        aria-controls="editRole-{{ $user->id }}">Edit</button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editRole-{{ $user->id }}"
        aria-labelledby="offcanvasEndLabel-{{ $user->id }}">
        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel-{{ $user->id }}" class="offcanvas-title">Edit Supplier
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body my-auto mx-0 flex-grow-0">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Something went wrong.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('suppliers.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('suppliers.includes.form')
            </form>
        </div>
    </div>
</div>
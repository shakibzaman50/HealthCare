
  @if (session('success'))
    <div class="alert alert-success alert-dismissible pl-6" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
    </div>
  @endif

  @if ($errors->any())
    @foreach ($errors->all() as $message)
      <div class="alert alert-danger alert-dismissible pl-6" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
    @endforeach
  @endif


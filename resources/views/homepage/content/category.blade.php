<div class="container mt-2 mb-2">
    <h3 class="text-center text-uppercase">All Category</h3>
    <div class="row">
        @foreach($categories as $category)
        <div class="col-md-2">
            <div class="product-box border text-center mb-3">
                <div class="image" style="position: relative;">
                    <a href="{{ route('category.page',$category['slug']) }}">
                        <!-- Placeholder image while loading -->
                        <img src="{{ asset('images/placeholder.png') }}" alt="" width="100%" class="product-img"
                            data-src="{{ asset('images/category/thumb/' . $category['image']) }}" style="opacity: 0;">
                        <!-- Spinner image -->
                        <img src="{{ asset('images/spinner.gif') }}" alt="Loading..." class="loading-spinner"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; display: block;">
                    </a>
                </div>
                <div class="product-body mb-3">
                    <p>{{ $category['name'] }}</p>
                </div>
                <div class="product-footer text-center mb-3">
                    <a type="button" class="btn-primary p-2 rounded mb-2" href="/category/{{$category['slug']}}">
                        <span id="loader_{{ $category['id'] }}" class="hidden" style="display: none;">
                            <img src="{{ asset('images/spinner.gif') }}" width="20">
                        </span>

                        See More ...
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
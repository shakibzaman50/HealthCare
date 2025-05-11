<div class="container mt-2 mb-2">
    <h3 class="text-center text-uppercase">{{ $title ?? ''}}</h3>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-2">
            <div class="product-box border text-center mb-3">
                <div class="image" style="position: relative;">
                    <a href="{{ route('front-product-show',$product['slug']) }}">
                        <!-- Placeholder image while loading -->
                        <img src="{{ asset('images/placeholder.webp') }}" alt="" width="100%" class="product-img"
                            data-src="{{ asset('images/products/thumb/' . $product['image']) }}" style="opacity: 0;">
                        <!-- Spinner image -->
                        <img src="{{ asset('images/spinner.gif') }}" alt="Loading..." class="loading-spinner"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; display: block;">
                    </a>
                </div>
                <div class="product-body mb-3">
                    <p>{{ $product['name'] }}</p>
                    @if($product['discount'] > 0)
                    <p><del>Tk. {{ $product['price'] }}</del> Tk. {{ $product['discount'] }}</p>
                    @else
                    <span>Tk. {{ $product['price'] }}</span>
                    @endif
                </div>
                <div class="product-footer text-center mb-3">
                    <button type="button" class="btn-primary p-2 rounded mb-2 add-to-cart"
                        data-product-id="{{ $product['id'] }}">
                        <span id="loader_{{ $product['id'] }}" class="hidden" style="display: none;">
                            <img src="{{ asset('images/loader.gif') }}" width="20">
                        </span>

                        Add To Cart
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
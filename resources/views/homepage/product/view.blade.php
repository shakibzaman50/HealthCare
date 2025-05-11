<div class="row">
    <div class="col-md-6">
        <div class="image" style="position: relative;">
            <a href="{{ route('front-product-show',$product->slug) }}">
                <!-- Placeholder image while loading -->
                <img src="{{ asset('images/placeholder.webp') }}" alt="" width="100%" class="product-img"
                    data-src="{{ asset('images/products/thumb/' . $product->image) }}" style="opacity: 0;">
                <!-- Spinner image -->
                <img src="{{ asset('images/spinner.gif') }}" alt="Loading..." class="loading-spinner"
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; display: block;">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="product-info">
            <h2>{{ $product->name }}</h2>
            @if($product->discount > 0)
            <p><del>Tk. {{ $product->price }}</del> Tk. {{ $product->discount }}</p>
            @else
            <span>Tk. {{ $product->price }}</span>
            @endif
            <span class="badge bg-info p-2">{{ $product->category['name'] }}</span>
        </div>
        <div class="cart-option m-2">
            <div class="row">
                <button type="button" class="btn-primary p-2 rounded mb-2 add-to-cart"
                    data-product-id="{{ $product->id }}">
                    <span id="loader_{{ $product->id }}" class="hidden" style="display: none;">
                        <img src="{{ asset('images/loader.gif') }}" width="20">
                    </span>

                    Add To Cart
                </button>
                <button type="button" class="btn-success p-2 rounded openModalButton"
                    data-product-id="{{ $product->id }}">ক্যাশ অন ডেলিভারিতে অর্ডার
                    করুন</button>
            </div>
            <div class="call-to-action mt-5">
                <div class="card p-4 shadow-lg text-center">
                    <h5 class="mb-3 text-primary fw-bold">
                        অর্ডার করতে কল / হোয়াটসঅ্যাপ করুন
                    </h5>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <a href="tel:{{ $globalSetting->phone }}"
                            class="btn btn-primary btn-sm d-flex align-items-center gap-2 shadow">
                            <i class="fas fa-phone-alt"></i> কল 📞 {{ $globalSetting->phone }}
                        </a>
                        <a href="https://wa.me/{{ $globalSetting->phone }}"
                            class="btn btn-success btn-sm d-flex align-items-center gap-2 shadow">
                            <i class="fab fa-whatsapp"></i> হোয়াটসঅ্যাপ
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-description mt-4">
            <h4 class="mb-3">Product Description</h4>
            <div class="description-content p-3 rounded">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    </div>
</div>
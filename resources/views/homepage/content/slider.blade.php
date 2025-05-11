<!--ROW-->
<div class="spacer"></div>
<div class="row py-3 rounded slider">
    <div class="col rounded">
        <div id="carouselExampleIndicators" class="carousel slide shadow-sm" data-bs-ride="true">
            <div class="carousel-indicators">
                @foreach($sliders as $slider)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $slider['id'] }}"
                    class="active" aria-current="true" aria-label="{{ $slider['name'] }}"></button>
                {{-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button> --}}
                @endforeach

            </div>
            <div class="carousel-inner rounded">
                @foreach($sliders as $slider)
                <div class="carousel-item active">
                    <img src="{{ asset('storage/' . $slider['image']) }}" class="d-block w-100"
                        alt="{{ $slider['name'] }}">
                    <div
                        class="w-50 h-100 mini-blog float-left position-absolute top-0 start-0 d-flex align-items-center">
                        <h3>
                            {{ $slider['text'] }}
                        </h3>
                    </div>
                </div>
                @endforeach

            </div>
            <button class="carousel-control-prev justify-content-start px-5" type="button"
                data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <p aria-hidden="true">&#10094;</p>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next justify-content-end px-5" type="button"
                data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <p aria-hidden="true">&#10095;</p>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
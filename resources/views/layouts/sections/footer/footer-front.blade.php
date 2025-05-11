<style>
  .cart-icon {
    position: relative;
    display: flex;
    align-items: center;
  }

  .cart-count {
    position: absolute;
    top: -5px;
    right: -10px;
    font-size: 0.75rem;
    padding: 3px 7px;
    border-radius: 50%;
    color: #fff;
  }

  .cart-total-price {
    font-size: 0.9rem;
    font-weight: bold;
    color: #000;
  }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    function updateCart() {
        $.ajax({
            url: '{{ route("cart.get") }}', // Replace with your route to get cart data
            method: 'GET',
            success: function(response) {
                // Update cart count
                $('.cart-count').text(response.totalItems);

                // Update total price
                $('.cart-total-price').text('৳ ' + response.totalPrice);

                // You can dynamically load cart items into the dropdown here if needed
            },
            error: function(xhr) {
                console.error('Could not load cart data');
            }
        });
    }

    // Call the function on page load
    updateCart();

    // You can also call this function after adding/removing items from the cart

    
});
</script>

<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="mediumBody">
        <div>
          <!-- the result to be displayed apply here -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer: Start -->
<footer class="landing-footer bg-body footer-text">
  <div class="footer-top position-relative overflow-hidden z-1">
    <img src="{{asset('assets/img/front-pages/backgrounds/footer-bg-'.$configData['style'].'.png')}}" alt="footer bg"
      class="footer-bg banner-bg-img z-n1" data-app-light-img="front-pages/backgrounds/footer-bg-light.png"
      data-app-dark-img="front-pages/backgrounds/footer-bg-dark.png" />
    <div class="container">
      <div class="row gx-0 gy-6 g-lg-10">
        <div class="col-lg-5">
          <a href="javascript:;" class="app-brand-link mb-6">
            <img src="{{ asset('storage/' . $globalSetting->logo) }}" width="100">
          </a>
          <p class="footer-text footer-logo-description mb-6">
            {{ $globalSetting->slogan }}
          </p>
          <form class="footer-form">
            <label for="footer-email" class="small">Subscribe to newsletter</label>
            <div class="d-flex mt-1">
              <input type="email" class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                id="footer-email" placeholder="Your email" />
              <button type="submit" class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">
                Subscribe
              </button>
            </div>
          </form>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <h6 class="footer-title mb-6">Demos</h6>
          <ul class="list-unstyled">
            <li class="mb-4">
              <a href="javascript:;" target="_blank" class="footer-link">About US</a>
            </li>
            <li class="mb-4">
              <a href="javascript:;" target="_blank" class="footer-link">Return Policy</a>
            </li>
            <li class="mb-4">
              <a href="javascript:;" target="_blank" class="footer-link">Refund Policy</a>
            </li>
            <li class="mb-4">
              <a href="javascript:;" target="_blank" class="footer-link">Contact Us</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <h6 class="footer-title mb-6">Category</h6>
          <ul class="list-unstyled">
            {{-- <li class="mb-4">
              <a href="javascript:;" class="footer-link">Pricing</a>
            </li>
            <li class="mb-4">
              <a href="javascript:;" class="footer-link">Payment<span class="badge bg-primary ms-2">New</span></a>
            </li>
            <li class="mb-4">
              <a href="javascript:;" class="footer-link">Checkout</a>
            </li>
            <li class="mb-4">
              <a href="javascript:;" class="footer-link">Help Center</a>
            </li>
            <li class="mb-4">
              <a href="javascript:;" target="_blank" class="footer-link">Login/Register</a>
            </li> --}}
          </ul>
        </div>
        <div class="col-lg-3 col-md-4">
          <h6 class="footer-title mb-6">Download our app</h6>
          <a href="javascript:void(0);" class="d-block mb-4"><img
              src="{{asset('assets/img/front-pages/landing-page/apple-icon.png')}}" alt="apple icon" /></a>
          <a href="javascript:void(0);" class="d-block"><img
              src="{{asset('assets/img/front-pages/landing-page/google-play-icon.png')}}" alt="google play icon" /></a>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom py-3 py-md-5">
    <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
      <div class="mb-2 mb-md-0">
        <span class="footer-bottom-text">©
          <script>
            document.write(new Date().getFullYear());

          </script>
        </span>
        <a href="{{config('variables.creatorUrl')}}" target="_blank"
          class="fw-medium text-white text-white">{{config('variables.creatorName')}},</a>
        <span class="footer-bottom-text"> Made with ❤️ for a better web.</span>
      </div>
      <div>
        <a href="{{config('variables.githubUrl')}}" class="me-3" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/github.svg')}}" alt="github icon" />
        </a>
        <a href="{{config('variables.facebookUrl')}}" class="me-3" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/facebook.svg')}}" alt="facebook icon" />
        </a>
        <a href="{{config('variables.twitterUrl')}}" class="me-3" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/twitter.svg')}}" alt="twitter icon" />
        </a>
        <a href="{{config('variables.instagramUrl')}}" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/instagram.svg')}}" alt="google icon" />
        </a>
      </div>
    </div>
  </div>
</footer>
<!-- Footer: End -->

<script>
  $(document).on('click', '#mediumButton', function(event) {
      event.preventDefault();
      let href = $(this).attr('data-attr');
      $.ajax({
          url: href,
          beforeSend: function() {
              $('#loader').show();
          },
          // return the result
          success: function(result) {
              $('#mediumModal').modal("show");
              $('#mediumBody').html(result).show();
          },
          complete: function() {
              $('#loader').hide();
          },
          error: function(jqXHR, testStatus, error) {
              console.log(error);
              alert("Page " + href + " cannot open. Error:" + error);
              $('#loader').hide();
          },
          timeout: 8000
      })
  });
</script>
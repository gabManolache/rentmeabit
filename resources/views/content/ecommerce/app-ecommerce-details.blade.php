@extends('layouts/contentLayoutMaster')

@section('title', 'Product Details')

@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/swiper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css'))}}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce-details.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-number-input.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-ratings.css')) }}">

@endsection

@section('content')
<!-- app e-commerce details start -->
<section class="app-ecommerce-details">
  <div class="card">
    <!-- Product Details starts -->
    <div class="card-body">
      <div class="row my-2">
        <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
          <div class="d-flex align-items-center justify-content-center">
            <img
              src="{{asset('images/pages/eCommerce/1.png')}}"
              class="img-fluid product-img"
              alt="product image"
            />
          </div>
        </div>
        <div class="col-12 col-md-7">
          <h4>{{$response['product']->title}}</h4>
          <span class="card-text item-company">By <a href="#" class="company-name">{{$response['product']->user->name}}</a></span>
          <div class="ecommerce-details-price d-flex flex-wrap mt-1">
            <h4 class="item-price me-1">${{$response['product']->price}}</h4>
            <div class="basic-ratings onset-event-ratings" data-rating="{{ $response['product']['average_rating']}}"></div>
          </div>
          <p class="card-text">Available - <span class="text-success">{{$response['product']->status}}</span></p>
          <p class="card-text">
            {{$response['product']->description}}
          </p>
          <ul class="product-features list-unstyled">
            <li><i data-feather="shopping-cart"></i> <span>Free Shipping</span></li>
            <li>
              <i data-feather="dollar-sign"></i>
              <span>EMI options available</span>
            </li>
          </ul>
          <hr/>
          <div class="product-color-options">
            <h6>Colors</h6>
            <ul class="list-unstyled mb-0">
              <li class="d-inline-block selected">
                <div class="color-option b-primary">
                  <div class="filloption bg-primary"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-success">
                  <div class="filloption bg-success"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-danger">
                  <div class="filloption bg-danger"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-warning">
                  <div class="filloption bg-warning"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-info">
                  <div class="filloption bg-info"></div>
                </div>
              </li>
            </ul>
          </div>
          <hr />
          <div class="d-flex flex-column flex-sm-row pt-1">
            <a href="#" class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0">
              <i data-feather="shopping-cart" class="me-50"></i>
              <span class="add-to-cart">Add to cart</span>
            </a>
            <a href="#" class="btn btn-outline-secondary btn-wishlist me-0 me-sm-1 mb-1 mb-sm-0">
              <i data-feather="heart" class="me-50"></i>
              <span>Wishlist</span>
            </a>

          </div>
        </div>
      </div>
    </div>
    <!-- Product Details ends -->

    <!-- Item features starts -->
    <div class="item-features">
      <div class="row text-center">
        <div class="col-12 col-md-4 mb-4 mb-md-0">
          <div class="w-75 mx-auto">
            <i data-feather="award"></i>
            <h4 class="mt-2 mb-1">100% Original</h4>
            <p class="card-text">Chocolate bar candy canes ice cream toffee. Croissant pie cookie halvah.</p>
          </div>
        </div>
        <div class="col-12 col-md-4 mb-4 mb-md-0">
          <div class="w-75 mx-auto">
            <i data-feather="clock"></i>
            <h4 class="mt-2 mb-1">10 Day Replacement</h4>
            <p class="card-text">Marshmallow biscuit donut dragée fruitcake. Jujubes wafer cupcake.</p>
          </div>
        </div>
        <div class="col-12 col-md-4 mb-4 mb-md-0">
          <div class="w-75 mx-auto">
            <i data-feather="shield"></i>
            <h4 class="mt-2 mb-1">1 Year Warranty</h4>
            <p class="card-text">Cotton candy gingerbread cake I love sugar plum I love sweet croissant.</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Item features ends -->

    <!-- Related Products starts -->
    <div class="card-body">

      <div class="mt-4 mb-2 text-center">
        <h4>Related Products</h4>
        <p class="card-text">People also search for this items</p>
      </div>



      <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
        <div class="swiper-wrapper">



        @foreach($response['related_products'] as $relatedProduct)

          <div class="swiper-slide">
            <a href="#">
              <div class="item-heading">

                <h5 class="text-truncate mb-0">{{$relatedProduct->title}}</h5>
                <small class="text-body">by {{$relatedProduct->name}}</small>
              </div>
              <div class="img-container w-50 mx-auto py-75">
                <img src="{{ $relatedProduct->main_photo_url }}" class="img-fluid" alt="image" />
              </div>
              <div class="item-meta">
                <div class="basic-ratings onset-event-ratings" data-rating="{{$relatedProduct->average_rating}}"></div> ({{$relatedProduct->total_votes}})
                <p class="card-text text-primary mb-0">${{$relatedProduct->price}}</p>
              </div>
            </a>
          </div>
          @endforeach

        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>
    <!-- Related Products ends -->
  </div>
</section>
<!-- app e-commerce details end -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/swiper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-ecommerce-details.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-number-input.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-ratings.js')) }}"></script>
@endsection

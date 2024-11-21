@extends('client.layouts')

@section('title')
    Chi Tiết Sản Phẩm
@endsection

@section('content')
    <div id="main">
        <!-- Breadcrumb Area start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-content">
                            <h1 class="breadcrumb-hrading">{{ $productDetail->name }}</h1>
                            <ul class="breadcrumb-links">
                                <li><a href="">Trang chủ</a></li>
                                <li>{{ $productDetail->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Area End -->
        <!-- Shop details Area start -->
        <section class="product-details-area mtb-60px">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="product-details-img product-details-tab">
                            <div class="zoompro-wrap zoompro-2">
                                <div class="zoompro-border zoompro-span">
                                    <img src="{{ $productDetail->image }} " alt=""  />
                                </div>
                            </div>
                            
                            <div id="gallery" class="product-dec-slider-2">
                                @foreach ($galleriesOfProduct as $gallery)
                                {{-- <a class="active" data-image=""
                                    data-zoom-image="">
                                    <img src="" alt="" />
                                </a> --}}
                                <a data-image=""
                                    data-zoom-image="">
                                    <img src="{{ $gallery }}" alt="" />
                                </a>
                                @endforeach 
                            </div>      
                    </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="product-details-content">
                            <h2>{{ $productDetail->name }}</h2>
                            <p class="reference">Thuộc danh mục:<span> {{ implode(', ',$categoriesOfProduct) }}</span></p>
                            <div class="pro-details-rating-wrap">
                                {{-- <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div> --}}
                                <span class="read-review"><a class="reviews" href="#">(3) Đánh giá</a></span>
                            </div>
                            <div class="pricing-meta">
                                <ul>
                                    {{-- <li class="old-price">
                                        <small>
                                            {{ number_format($productDetail->price, 0, '.', ',') }} 
                                        </small>
                                        
                                    </li> --}}
                                    <li style="color:rgb(207, 41, 43)" class="old-price not-cut ">
                                            {{ number_format($productDetail->sale, 0, '.', ',') }}$
                                    </li>
                                    {{-- <li class="discount-price">
                                        -{{ number_format((($productDetail->price - $productDetail->sale) / $productDetail->price) * 100, 0) }}%
                                    </li> --}}

                                </ul>
                            </div>
                            <p>{{ $productDetail->short_description }}</p>
                            {{-- <div class="pro-details-list">
                                <ul>
                                    <li>- 0.5 mm Dail</li>
                                    <li>- Inspired vector icons</li>
                                    <li>- Very modern style</li>
                                </ul>
                            </div> --}}
                            <div class="pro-details-quality mt-0px">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                                </div>
                                <div class="pro-details-cart btn-hover">
                                    <a href="#"> + Thêm Giỏ Hàng</a>
                                </div>
                            </div>
                            <div class="pro-details-wish-com">
                                <div class="pro-details-wishlist">
                                    <a href="#"><i class="ion-android-favorite-outline"></i>Thêm vào danh sách yêu
                                        thích</a>
                                </div>
                                <div class="pro-details-compare">
                                    <a href="#"><i class="ion-ios-shuffle-strong"></i>Thêm vào so sánh sản phẩm</a>
                                </div>
                            </div>
                            <div class="pro-details-social-info">
                                <span>Share</span>
                                <div class="social-info">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="ion-social-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-google"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-instagram"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pro-details-policy">
                                <ul>
                                    <li>
                                        <img src="assets/images/icons/policy.png" alt="" />
                                        <span>Chính sách bảo mật (Đảm bảo quyền riêng tư cho người dùng và khách hàng khi sử
                                            dụng trang web)</span>
                                    </li>
                                    <li>
                                        <img src="assets/images/icons/policy-2.png" alt="" />
                                        <span>Chính sách giao hàng (Miễn phí giao hàng khi đặt 3-5 sản phẩm) </span>
                                    </li>
                                    <li><img src="assets/images/icons/policy-3.png" alt="" />
                                        <span>Chính sách đổi trả (Đổi trả 1 đổi 1 trong vòng 15 ngày)
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Shop details Area End -->
        <!-- product details description area start -->
        <div class="description-review-area mb-60px">
            <div class="container">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav">
                        <a data-bs-toggle="tab" href="#des-details1">Mô tả sản phẩm</a>
                        <a class="active" data-bs-toggle="tab" href="#des-details2">Chi tiết thêm sản phẩm</a>
                        <a data-bs-toggle="tab" href="#des-details3">Đánh giá sản phẩm </a>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="des-details2" class="tab-pane active">
                            <div class="product-anotherinfo-wrapper">
                                <ul>
                                    <li><span>Trọng Lượng </span>{{ $productDetail->weight }} g</li>
                                    <li><span>Số trang</span>{{ $productDetail->page }}</li>
                                    <li><span>Năm xuất bản </span>{{ $productDetail->released }}</li>
                                    <li><span>Tác giả</span> {{ $productDetail->author }}</li>
                                    <li><span>Nhà xuất bản</span> {{ $productDetail->publisher }}</li>
                                </ul>
                            </div>
                        </div>
                        <div id="des-details1" class="tab-pane">
                            <div class="product-description-wrapper">

                                <p>
                                    {{ $productDetail->long_description }}
                                </p>
                            </div>
                        </div>
                        <div id="des-details3" class="tab-pane">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="review-wrapper">
                                        @foreach($getListComments as $comment)
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img class="rounded-circle" src="{{ $comment->user->avatar ?? ''}} " alt="" width="100" height="100"/>
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4> {{ $comment->user->name }}</h4>
                                                        </div>
                                                        
                                                        <div class="rating-product">
                                                           <small>{{ $comment->created_at }}</small> 
                                                            {{-- <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>
                                                      
                                                        {{ $comment->content }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                       @endforeach
                                    </div>
                                </div>
                                {{-- <div class="col-lg-5">
                                    <div class="ratting-form-wrapper pl-50">
                                        <h3>Đánh giá sản phẩm</h3>
                                        <div class="ratting-form">
                                            <form action="#"> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style form-submit">
                                                            <textarea name="Your Review" placeholder="Message"></textarea>
                                                            <input type="submit" value="Gửi" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- product details description area end -->
        <!-- Recent Add Product Area Start -->
        <section class="recent-add-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Section Title -->
                        <div class="section-title">
                            <h2>Sản phẩm liên quan </h2>
                            <p>({{ count($relatedProducts) }}) sản phẩm liên quan </p>
                        </div>
                        <!-- Section Title -->
                    </div>
                </div>

                <!-- Recent Product slider Start -->
                <div class="recent-product-slider owl-carousel owl-nav-style">
                    @foreach ($relatedProducts as $related)
                        <!-- Single Item -->
                        <article class="list-product">
                            <div class="img-block">
                                <a href="{{ route('productDetail', $related->slug) }}" class="thumbnail">
                                    <img class="first-img" src="{{ $related->image }}" alt="" />
                                    {{-- <img class="second-img" src="assets/images/product-image/organic/product-12.jpg"
                                    alt="" /> --}}
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="ion-ios-search-strong"></i>
                                    </a>
                                </div>
                            </div>
                            <ul class="product-flag">
                                <li class="new">New</li>
                            </ul>
                            <div class="product-decs">
                                <a class="inner-link" href="{{ route('productDetail', $related->slug) }}"><span>{{ $related->sku }}</span></a>
                                <h2><a href="single-product.html" class="product-link">{{ $related->name }}</a></h2>
                                
                            </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="old-price"><small>{{ number_format($related->price, 0, '.', ',') }}</small></li>
                                        <li class="current-price">{{ number_format($related->sale, 0, '.', ',') }}$
                                        </li>
                                        <li class="discount-price">
                                            -{{ number_format((($related->price - $related->sale) / $related->price) * 100, 0) }}%
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="add-to-link">
                                <ul>
                                    <li class="cart"><a class="cart-btn" href="#">Thêm Giỏ Hàng </a></li>
                                    <li>
                                        <a href="wishlist.html"><i class="ion-android-favorite-outline"></i></a>
                                    </li>
                                    <li>
                                        <a href="compare.html"><i class="ion-ios-shuffle-strong"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    @endforeach

                </div>
                <!-- Recent product slider end -->
            </div>
        </section>
        <!-- Recent product area end -->
        <!-- Recent Add Product Area Start -->
        <section class="recent-add-area mt-30 mb-30px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Section Title -->
                        <div class="section-title">
                            <h2>Sản phẩm cùng danh mục </h2>
                            <p>({{ count($getProductsByCategory) }}) sản phẩm cùng danh mục</p>
                        </div>
                        <!-- Section Title -->
                    </div>
                </div>
                <!-- Recent Product slider Start -->
                <div class="recent-product-slider owl-carousel owl-nav-style">
                    <!-- Single Item -->
                    @foreach ($getProductsByCategory as $get)
                        <!-- Single Item -->
                        <article class="list-product">
                            <div class="img-block">
                                <a href="{{ route('productDetail', $get->slug) }}" class="thumbnail">
                                    <img class="first-img" src="{{ $get->image }}" alt="" />
                                    {{-- <img class="second-img" src="assets/images/product-image/organic/product-12.jpg"
                                    alt="" /> --}}
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="ion-ios-search-strong"></i>
                                    </a>
                                </div>
                            </div>
                            <ul class="product-flag">
                                <li class="new">New</li>
                            </ul>
                            <div class="product-decs">
                                <a class="inner-link" href="{{ route('productDetail', $get->slug) }}"><span>{{ $get->sku }}</span></a>
                                <h2><a href="single-product.html" class="product-link">{{ $get->name }}</a></h2>
        
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="old-price"><small>{{ number_format($get->price, 0, '.', ',') }}</small></li>
                                        <li class="current-price">{{ number_format($get->sale, 0, '.', ',') }}$
                                        </li>
                                        <li class="discount-price">
                                            -{{ number_format((($get->price - $get->sale) / $get->price) * 100, 0) }}%
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="add-to-link">
                                <ul>
                                    <li class="cart"><a class="cart-btn" href="#">Thêm Giỏ Hàng </a></li>
                                    <li>
                                        <a href="wishlist.html"><i class="ion-android-favorite-outline"></i></a>
                                    </li>
                                    <li>
                                        <a href="compare.html"><i class="ion-ios-shuffle-strong"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    @endforeach

                </div>
                <!-- Recent product slider end -->
            </div>
        </section>
        <!-- Recent product area end -->
    </div>
@endsection
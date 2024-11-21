<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Section Title -->
            <div class="section-title">
                <h2>Khuyến mãi hấp dẫn</h2>
                <p>Thêm sản phẩm giá sốc vào giỏ hàng của bạn</p>
            </div>
            <!-- Section Title -->
        </div>
    </div>
    <!-- Hot Deal Slider 2 Start -->
    <div class="hot-deal-2 owl-carousel owl-nav-style">
        <!-- Single Item -->
        @foreach ($product_sale as $product)
        <article class="list-product">
            <div class="hot-item-inner">
                <div class="img-block">
                    <a href="single-product.html" class="thumbnail">
                        <img class="first-img"
                            src="{{ asset('client/assets/images/product-image/organic/test.webp') }}"
                            alt="" />
                        <img class="second-img"
                            src="{{ asset('client/assets/images/product-image/organic/test.webp') }}"
                            alt="" />
                    </a>
                </div>
                <ul class="product-flag">
                    <li class="new">Mới</li>
                </ul>
            </div>
            <div class="product-wrapper" style="margin-top: 5%">
                <div class="product-decs">
                    <a class="inner-link" href="shop-4-column.html"><span>{{$product->ProductCategories?->first()?->category->name}}</span></a>
                    <h2><a href="single-product.html" class="product-link">{{Str::limit($product->name,20,'...')}}</a></h2>
                    <div class="rating-product">
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                    </div>
                    <div class="pricing-meta">
                        <ul>
                            <li class="old-price">{{number_format($product->price,0,'.','.')}}₫</li>
                            <li class="current-price">{{number_format($product->sale,0,'.','.')}}₫</li>
                            <li class="discount-price">-{{round((($product->price-$product->sale)/$product->price*100))}}%</li>
                        </ul>
                    </div>
                    <div class="add-to-link">
                        <ul>
                            <li class="cart"><a class="cart-btn" href="#">Thêm vào giỏ hàng </a></li>
                            <li>
                                <a href="wishlist.html"><i class="ion-android-favorite-outline"></i></a>
                            </li>
                            <li>
                                <a href="compare.html"><i class="ion-ios-shuffle-strong"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="in-stock">Chỉ còn: <span>{{$product->quantity}} Sản phẩm</span></div>
                <div class="clockdiv">
                    {{-- <div class="title_countdown">Nhanh lên! <br> Ưu đãi sắp kết thúc</div> --}}
                    {{-- <div data-countdown="2024/11/19"></div> --}}
                </div>
            </div>
        </article>
        @endforeach
        
    </div>
    <!-- Hot Deal Slider 2 Start -->
</div>

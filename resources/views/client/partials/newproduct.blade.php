<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Section Title -->
            <div class="section-title">
                <h2>Hàng mới về</h2>
                <p>Thêm sản phẩm mới vào giỏ hàng của bạn</p>
            </div>
            <!-- Section Title -->
        </div>
    </div>
    <!-- Recent Product slider Start -->
    <div class="recent-product-slider owl-carousel owl-nav-style">
        <!-- Product Single Item -->
        @foreach ($product_new as $product)
            <div class="product-inner-item">
                @foreach ($product as $new)
                    <article class="list-product mb-30px">
                        <div class="img-block">
                            <a href="{{ route('productDetail', ['slug' => $new->slug]) }}" class="thumbnail">
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
                        <div class="product-decs">
                            <a class="inner-link"
                                href="shop-4-column.html"><span>{{ $new->ProductCategories?->first()?->category->name }}</span></a>
                            <h2><a href="single-product.html"
                                    class="product-link">{{ Str::limit($new->name, 20, '...') }}</a>
                            </h2>
                            <div class="rating-product">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                            </div>
                            <div class="pricing-meta">
                                @if ($new->sale)
                                    <ul>
                                        <li class="old-price">{{ number_format($new->price, 0, ',') }}₫</li>
                                        <li class="current-price">{{ number_format($new->sale, 0, ',') }}₫</li>
                                        <li class="discount-price">
                                            -{{ round((($new->price - $new->sale) / $new->price) * 100) }}%</li>
                                    </ul>
                                @else
                                    <ul>
                                        <li class="old-price not-cut">{{ number_format($new->price, 0, ',') }}₫</li>
                                    </ul>
                                @endif
                            </div>
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
                    </article>
                @endforeach
            </div>
        @endforeach
    </div>
    <!-- Recent Area Slider End -->
</div>

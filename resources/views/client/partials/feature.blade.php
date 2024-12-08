<div class="container">

    <div class="row">
        <!-- left side -->
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="feature-left">
                <img src="{{ asset('client/assets/images/feature-bg/1.jpg') }}" alt="" class="img-responsive" />
            </div>
        </div>
        <!-- right side -->
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <!-- Section Title -->
            <div class="section-title">
                <h2>Sản phẩm nổi bật</h2>
                <p>Thêm sản phẩm nổi bật vào giỏ hàng của bạn</p>
            </div>
            <!-- Section Title -->
            <!-- Feature slide 2 start -->
            <div class="feature-slider-2 owl-carousel owl-nav-style">
                <!-- slngle item -->
                @foreach ($product2 as $product)
                <div class="feature-slider-item">
                    @foreach ($product as $item)
                    <article class="list-product">
                        <div class="img-block">
                            <a href="{{ route('productDetail', ['slug' => $item->slug]) }}" class="thumbnail">
                                <img class="first-img"
                                    src="{{ asset($item->image) }}"
                                    alt="" />
                                <img class="second-img"
                                    src="{{ asset($item->image) }}"
                                    alt="" />
                            </a>

                        </div>
                        <div class="product-decs">
                            <a class="inner-link" href="{{ route('danhmucSanpham',  $item->ProductCategories?->first()?->category->slug) }}"><span>{{ $item->ProductCategories?->first()?->category->name }}</span></a>
                            <h2><a href="{{ route('productDetail', ['slug' => $item->slug]) }}" class="product-link">{{ Str::limit($item->name, 20, '...') }}</a></h2>
                            
                            {{-- <ul class="list-unstyled d-flex align-items-center">
                                <li class="me-3"> 
                                    <a href="#" class="add-to-cart text-decoration-none fs-3" data-id="{{ $item->id }}">
                                        <i class="bi bi-cart-plus"></i>
                                    </a>
                                </li>
                                <li class="me-3">
                                    <a href="wishlist.html" class="text-decoration-none fs-3">
                                        <i class="ion-android-favorite-outline"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="compare.html" class="text-decoration-none fs-3">
                                        <i class="ion-ios-shuffle-strong"></i>
                                    </a>
                                </li>
                            </ul> --}}
                         
                            <div class="rating-product">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                            </div>
                            <div class="pricing-meta">
                                @if ($item->sale)
                                <ul>
                                    <li class="old-price">{{number_format($item->price,0,".",'.')}}₫</li>
                                    <li class="current-price">{{number_format($item->sale,0,".",'.')}}₫</li>
                                </ul>
                                @else 
                                <ul>
                                    <li class="old-price not-cut">{{number_format($item->price,0,".",'.')}}₫</li>
                                </ul>

                                @endif
                                
                            </div>
                        </div>
                    </article>
                    @endforeach
                    
                    
                </div>
                @endforeach
                
            </div>
            <!-- Feature slide 2 End -->
        </div>
    </div>
</div>

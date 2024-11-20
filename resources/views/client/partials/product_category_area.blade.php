<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- Shop Top Area Start -->
            <div class="shop-top-bar">
                <!-- Left Side start -->
                <div class="shop-tab nav mb-res-sm-15">
                    <a class="active" data-bs-toggle="tab">
                        <i class="fa fa-th show_grid"></i>
                    </a>
                    <p>{{$category->CategoryProducts->count()}} sản phẩm</p>
                </div>
                <!-- Left Side End -->
                <!-- Right Side Start -->
                <div class="select-shoing-wrap">
                    <div class="shot-product">
                        <p>Sắp Xếp Theo:</p>
                    </div>
                    <div class="shop-select">
                        <form action="" method="post">
                            <select>
                                <option selected value="">--Sắp xếp theo--</option>
                                <option value="">Mới Nhất</option>
                                <option value="">A to Z</option>
                                <option value=""> Z to A</option>
                                <option value="">In stock</option>
                            </select>
                        </form>
                    </div>
                </div>
                <!-- Right Side End -->
            </div>
            <!-- Shop Top Area End -->

            <!-- Shop Bottom Area Start -->
            <div class="shop-bottom-area mt-35">
                <!-- Shop Tab Content Start -->
                <div class="tab-content jump">
                    <!-- Tab One Start -->
                    <div id="shop-1" class="tab-pane active">
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-xl-3 col-md-4 col-sm-6">
                                <article class="list-product">
                                    <div class="img-block">
                                        <a href="single-product.html" class="thumbnail">
                                            <img class="first-img" src="{{ asset('client/assets/images/product-image/organic/product-1.jpg') }}" alt="" />
                                            <img class="second-img" src="{{ asset('client/assets/images/product-image/organic/product-1.jpg') }}" alt="" />
                                        </a>
                                        
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">Mới</li>
                                    </ul>
                                    <div class="product-decs">
                                        <a class="inner-link" href="shop-4-column.html"><span>{{$category->name}}</span></a>
                                        <h2><a href="single-product.html" class="product-link">{{$product->product->name}}</a></h2>
                                        <div class="pricing-meta">
                                            <ul>
                                                <li class="old-price">{{$product->product->price}}</li>
                                                <li class="current-price">{{$product->product->sale}}</li>
                                                @if ($product->product->sale)
                                                <li class="discount-price">-{{ round((($product->product->price - $product->product->sale) / $product->product->price) * 100) }}%</li>
                                                @endif
                                            </ul>
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
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Tab One End -->
                </div>
                <!-- Shop Tab Content End -->
                <!--  Pagination Area Start -->
                <div class="d-flex justify-content-center align-items-center p-5">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
                <!--  Pagination Area End -->
            </div>
            <!-- Shop Bottom Area End -->
        </div>
    </div>
</div>
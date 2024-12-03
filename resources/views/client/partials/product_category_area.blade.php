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
                    <p>Có {{ $category->CategoryProducts->count() }} sản phẩm</p>
                </div>
                <!-- Left Side End -->
                <!-- Right Side Start -->
                <div class="select-shoing-wrap">
                    <div class="shot-product">
                        <p>Sắp Xếp Theo:</p>
                    </div>
                    <div class="shop-select">
                        <form action="{{ route('danhmucSanpham', ['slug' => $slug]) }}" method="get">
                            <select class="form-select" name="sort_by" onchange="this.form.submit()">
                                <option value="name_asc" @selected($sortBy == 'name_asc')>Tên sản phẩm: A → Z</option>
                                <option value="name_desc" @selected($sortBy == 'name_desc')>Tên sản phẩm: Z → A</option>
                                <option value="price_asc" @selected($sortBy == 'price_asc')>Giá từ thấp đến cao</option>
                                <option value="price_desc" @selected($sortBy == 'price_desc')>Giá từ cao đến thấp</option>
                                <option value="created_desc" @selected($sortBy == 'created_desc')>Mới nhất</option>
                                <option value="created_asc" @selected($sortBy == 'created_asc')>Cũ nhất</option>
                                <option value="discount_desc" @selected($sortBy == 'discount_desc')>Giảm giá nhiều nhất</option>
                                <option value="popular" @selected($sortBy == 'popular')>Bán chạy nhất</option>
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
                                                <img class="first-img" src="{{ asset($product->image) }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset($product->image) }}"
                                                    alt="" />
                                            </a>

                                        </div>
                                        <ul class="product-flag">
                                            <li class="new">Mới</li>
                                        </ul>
                                        <div class="product-decs">
                                            <a class="inner-link"
                                                href="shop-4-column.html"><span>{{ $category->name }}</span></a>
                                            <h2><a href="single-product.html"
                                                    class="product-link">{{ $product->name }}</a></h2>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="old-price">{{ $product->price }} VND</li>
                                                    <li class="current-price">{{ $product->sale }} VND</li>
                                                    @if ($product->sale)
                                                        <li class="discount-price">
                                                            -{{ round((($product->price - $product->sale) / $product->price) * 100) }}%
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="add-to-link">
                                            <ul>
                                                <li class="cart"><a class="cart-btn" href="#">Thêm vào giỏ hàng
                                                    </a></li>
                                                <li>
                                                    <a href="wishlist.html"><i
                                                            class="ion-android-favorite-outline"></i></a>
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

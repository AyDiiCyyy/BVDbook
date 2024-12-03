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
                                            <a href="{{ route('productDetail', ['slug' => $product->slug]) }}" class="thumbnail">
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
                                            <a class="inner-link" href="{{ route('danhmucSanpham',  $product->ProductCategories?->first()?->category->slug) }}"><span>{{ $product->ProductCategories?->first()?->category->name }}</span></a>

                                                <h2><a href="{{ route('productDetail', ['slug' => $product->slug]) }}" class="product-link">{{ Str::limit($product->name, 20, '...') }}</a></h2>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        @if($product->sale > 0) 
                                                            <li class="old-price">{{ number_format($product->price, 0, '.', '.') }}₫</li>
                                                            <li class="current-price">{{ number_format($product->sale, 0, '.', '.') }}₫</li>
                                                            <li class="discount-price">
                                                                -{{ round((($product->price - $product->sale) / $product->price) * 100) }}%
                                                            </li>
                                                        @else
                                                            <li class="current-price">{{ number_format($product->price, 0, '.', '.') }}₫</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                        </div>
                                        <div class="add-to-link">
                                            <ul>
                                                <li class="cart"><a class="cart-btn add-to-cart"
                                                        data-id="{{ $product->id }}" href="#">Thêm vào giỏ hàng
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Gỡ bỏ sự kiện click cũ nếu có
        $('.add-to-cart').off('click').on('click', function(e) {
            e.preventDefault(); // Ngừng hành động mặc định của thẻ <a>

            // Lấy ID sản phẩm và số lượng từ giao diện người dùng
            let productId = $(this).data('id');

            // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
            $.ajax({
                url: "{{ route('cart.add') }}", // URL của route cart.add
                method: "POST", // Phương thức POST
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token
                    product_id: productId, // ID sản phẩm
                    quantity: 1
                },
                success: function(response) {
                    console.log(response);
                    $('#cart-count').text(response.cart_count);
                    // Gọi hàm cập nhật giỏ hàng mà không cần reload
                    $(".item-quantity-tag").html(response.total_quantity);
                    $.ajax({
                        url: "{{ route('cart.get') }}", // Route trả về HTML của giỏ hàng
                        method: "GET",
                        success: function(response) {
                            console.log(response);
                            $('#cart-right').html(
                                response); // Cập nhật phần tử giỏ hàng
                        },
                        error: function() {
                            Swal.fire({
                                title: "Thất bại!",
                                text: "Không thể tải giỏ hàng, vui lòng thử lại!",
                                icon: "error",
                                confirmButtonText: "OK",
                            });
                        }
                    });

                    // Hiển thị thông báo thành công từ response
                    Swal.fire({
                        title: "Thành công!",
                        text: "Sản phẩm đã được thêm vào giỏ hàng!",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                },
                error: function(xhr) {
                    // Xử lý lỗi khi người dùng chưa đăng nhập
                    if (xhr.status === 401) {
                        Swal.fire({
                            title: "Thất bại!",
                            text: "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!",
                            icon: "error",
                            confirmButtonText: "OK",
                        }).then(() => {
                            window.location.href =
                                "{{ route('login') }}"; // Chuyển hướng đến trang đăng nhập
                        });

                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Hiển thị thông báo lỗi cụ thể từ server (nếu có)
                        Swal.fire({
                            title: "Thất bại!",
                            text: xhr.responseJSON.message, // Lấy message từ server
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    } else {
                        // Thông báo chung nếu không có message cụ thể
                        Swal.fire({
                            title: "Thất bại!",
                            text: "Có lỗi xảy ra, vui lòng thử lại sau!",
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                }
            });
        });

        // Hàm cập nhật giỏ hàng ở phần cartright
        function updateCartRight() {
            $.ajax({
                url: "{{ route('cart.get') }}", // Route trả về HTML của giỏ hàng
                method: "GET",
                success: function(response) {
                    $('#cart-right').html(response); // Cập nhật phần tử giỏ hàng
                },
                error: function() {
                    Swal.fire({
                        title: "Thất bại!",
                        text: "Không thể tải giỏ hàng, vui lòng thử lại!",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            });
        }
    });
</script>

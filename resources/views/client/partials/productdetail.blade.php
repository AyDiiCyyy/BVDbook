@extends('client.layouts')

@section('title')
    Chi Tiết Sản Phẩm
@endsection

@section('content')
    <!-- Breadcrumb Area start -->
    <section class="breadcrumb-area" style="margin-top: -30px; padding: 110px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">{{ $productDetail->name }}</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="#">Trang chủ</a></li>
                            <li>{{ $productDetail->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->
    <!-- Shop details Area start -->
    <!-- Shop details Area start -->
    <section class="product-details-area mtb-60px" style="margin-top: -50px">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-img product-details-tab">
                        <div class="product-image"
                            style="width: 450px; height: 450px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-color: #f5f5f5; border-radius: 8px; border: 1px solid #ddd; margin: 0 auto;">
                            <img id="main-image" src="{{ asset($productDetail->image) }}" alt=""
                                style="max-width: 100%; max-height: 100%; object-fit: contain;" />
                        </div>
                        <div id="gallery" class="product-dec-slider-2">
                            <a class="active" href="javascript:void(0);" data-image="{{ asset($productDetail->image) }}">
                                <img src="{{ asset($productDetail->image) }}" alt=""
                                    style="width: 100px; height: 100px; object-fit: contain;" />
                            </a>
                            @foreach ($galleriesOfProduct as $gallery)
                                <a href="javascript:void(0);" data-image="{{ asset($gallery) }}">
                                    <img src="{{ asset($gallery) }}" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain;" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <h2 style="line-height: 30px">{{ $productDetail->name }}</h2>
                        <p class="reference">Thuộc danh mục: <span>{{ implode(',', $categoriesOfProduct) }}</span></p>
                        <div class="pro-details-rating-wrap">
                            <div class="rating-product">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                            </div>
                        </div>
                        <div class="pricing-meta">
                            <ul>
                                @if ($productDetail->sale)
                                    <li class="old-price">
                                        <small>
                                            {{ number_format($productDetail->price, 0, '.', '.') }}₫
                                        </small>
                                    </li>
                                    <li style="color:rgb(207, 41, 43)" class="old-price not-cut ">
                                        {{ number_format($productDetail->sale, 0, '.', '.') }}₫
                                    </li>
                                    <li class="discount-price" style="margin: 22px 3px">
                                        -{{ number_format((($productDetail->price - $productDetail->sale) / $productDetail->price) * 100, 0) }}%
                                    </li>
                                @else
                                    <li class="old-price not-cut ">
                                        {{ number_format($productDetail->price, 0, '.', '.') }}₫
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <p>{{ $productDetail->short_description }}</p>
                        <div class="pro-details-quality mt-0px">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                            </div>
                            <div class="pro-details-cart btn-hover">
                                <a href="#" class="add-to-cart-btn" data-product-id="{{ $productDetail->id }}"> +
                                    Thêm Giỏ Hàng</a>
                            </div>
                        </div>
                        {{-- <div class="pro-details-wish-com">
                            <div class="pro-details-wishlist">
                                <a href="#"><i class="ion-android-favorite-outline"></i>Thêm vào danh sách yêu
                                    thích</a>
                            </div>
                            <div class="pro-details-compare">
                                <a href="#"><i class="ion-ios-shuffle-strong"></i>Thêm vào so sánh sản phẩm</a>
                            </div>
                        </div> --}}
                        <div class="pro-details-social-info">
                            <span>Chia sẻ</span>
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
                                    <img src="{{ asset('client/assets/images/icons/policy.png') }}" alt="" />
                                    <span>Chính sách bảo mật (Đảm bảo quyền riêng tư cho người dùng và khách hàng khi sử
                                        dụng trang web)</span>
                                </li>
                                <li>
                                    <img src="{{ asset('client/assets/images/icons/policy-2.png') }}" alt="" />
                                    <span>Chính sách giao hàng (Miễn phí giao hàng khi đặt 3-5 sản phẩm) </span>
                                </li>
                                <li><img src="{{ asset('client/assets/images/icons/policy-3.png') }}" alt="" />
                                    <span>Chính sách đổi trả (Đổi trả 1 đổi 1 trong vòng 15 ngày)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop details Area End -->
    <!-- Shop details Area End -->
    <!-- product details description area start -->
    <div class="description-review-area mb-60px">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav">
                    <a data-bs-toggle="tab" href="#des-details1">Mô tả sản phẩm</a>
                    @if ($orderDetail)
                        <a data-bs-toggle="tab" href="#des-details2">Chi tiết thêm sản phẩm</a>
                        <a class="active" data-bs-toggle="tab" href="#des-details3">Đánh giá sản phẩm
                            <span id="review-count">({{ count($getListComments) }})</span></a>
                    @else
                        <a class="active" data-bs-toggle="tab" href="#des-details2">Chi tiết thêm sản phẩm</a>
                        <a data-bs-toggle="tab" href="#des-details3">Đánh giá sản phẩm <span
                                id="review-count">({{ count($getListComments) }})</span></a>
                    @endif
                </div>
                <div class="tab-content description-review-bottom">
                    @if ($orderDetail)
                        <div id="des-details2" class="tab-pane">
                        @else
                            <div id="des-details2" class="tab-pane active">
                    @endif
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
                {{-- comment --}}
                @if ($orderDetail)
                    <div id="des-details3" class="tab-pane active">
                    @else
                        <div id="des-details3" class="tab-pane ">
                @endif
                <div class="row">
                    <div class="col-lg-7">
                        <div class="review-wrapper" id="review-wrapper">
                            @foreach ($getListComments as $comment)
                                <div class="single-review">
                                    <div class="review-img">
                                        <img class="rounded-circle"
                                            src="{{ $comment->user->avatar ?? asset('assets/img/user2-160x160.jpg') }} "
                                            alt="" width="100" height="100" />
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4> {{ $comment->user->name }}</h4>
                                                </div>

                                                <div class="rating-product">
                                                    <small>{{ $comment->created_at->format('d-m-Y H:i') }}</small>

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
                    <div class="col-lg-5">
                        <div class="ratting-form-wrapper pl-50">

                            @if ($orderDetail)
                                <h3>Đánh giá sản phẩm </h3>
                                <div class="ratting-form mt-4">
                                    <form id="comment-form"
                                        action="{{ route('client.product.comment', $productDetail->id) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="oder_detail_id" value="{{ $orderDetail->id }}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="rating-form-style form-submit">
                                                    <textarea name="content" placeholder="Nhập bình luận của bạn" required></textarea>
                                                    <button type="submit" class="btn btn-success">Gửi bình luận</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <p>Bạn không thể bình luận cho sản phẩm này, hãy mua hàng và để lại đánh giá để cải thiện
                                    trải nghiệm mua hàng.</p>
                            @endif
                        </div>
                    </div>
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
                <!-- Single Item -->
                @foreach ($relatedProducts as $related)
                    <article class="list-product">
                        <div class="img-block">
                            <a href="{{ route('productDetail', $related->slug) }}" class="thumbnail">
                                <img class="first-img" src="{{ asset($related->image) }}" alt="" />
                                <img class="second-img" src="{{ asset($related->image) }}" alt="" />
                            </a>

                        </div>
                        <ul class="product-flag">
                            <li class="new">Mới</li>
                        </ul>
                        <div class="product-decs">
                            <a class="inner-link"
                                href="#"><span>{{ implode(' ', $categoriesOfProduct) }}</span></a>
                            <h2><a href="{{ route('productDetail', $related->slug) }}"
                                    class="product-link">{{ Str::limit($related->name, 15, '...') }}</a></h2>
                            <div class="rating-product">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                            </div>
                            <div class="pricing-meta">
                                <ul>
                                    @if ($related->sale)
                                        <li class="old-price">
                                            <small>
                                                {{ number_format($related->price, 0, '.', '.') }}₫
                                            </small>

                                        </li>
                                        <li style="color:rgb(207, 41, 43)" class="old-price not-cut ">
                                            {{ number_format($related->sale, 0, '.', '.') }}₫
                                        </li>
                                        <li class="discount-price">
                                            -{{ number_format((($related->price - $related->sale) / $related->price) * 100, 0) }}%
                                        </li>
                                    @else
                                        <li class="old-price not-cut ">
                                            {{ number_format($related->price, 0, '.', '.') }}₫
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="add-to-link">
                            <ul>
                                <li class="cart"><a class="add-to-cart cart-btn" data-product-id="{{ $related->id }}"
                                        href="#">Thêm Giỏ Hàng </a>
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
                @foreach ($getProductsByCategory as $product)
                    <article class="list-product">
                        <div class="img-block">
                            <a href="{{ route('productDetail', $product->slug) }}" class="thumbnail">
                                <img class="first-img" src="{{ asset($product->image) }}" alt="" />
                                <img class="second-img" src="{{ asset($product->image) }}" alt="" />
                            </a>

                        </div>
                        <ul class="product-flag">
                            <li class="new">Mới</li>
                        </ul>
                        <div class="product-decs">
                            <a class="inner-link"
                                href="#"><span>{{ implode(' ', $categoriesOfProduct) }}</span></a>
                            <h2><a href="{{ route('productDetail', $product->slug) }}"
                                    class="product-link">{{ Str::limit($product->name, 15, '...') }}</a></h2>
                            <div class="rating-product">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                            </div>
                            <div class="pricing-meta">
                                <ul>
                                    @if ($product->sale)
                                        <li class="old-price">
                                            <small>
                                                {{ number_format($product->price, 0, '.', '.') }}₫
                                            </small>

                                        </li>
                                        <li style="color:rgb(207, 41, 43)" class="old-price not-cut ">
                                            {{ number_format($product->sale, 0, '.', '.') }}₫
                                        </li>
                                        <li class="discount-price">
                                            -{{ number_format((($product->price - $product->sale) / $product->price) * 100, 0) }}%
                                        </li>
                                    @else
                                        <li class="old-price not-cut ">
                                            {{ number_format($product->price, 0, '.', '.') }}₫
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="add-to-link">
                            <ul>
                                <li class="cart"><a class="add-to-cart cart-btn" data-product-id="{{ $product->id }}"
                                        href="#">Thêm Giỏ Hàng </a></li>
                            </ul>
                        </div>
                    </article>
                @endforeach
            </div>
            <!-- Recent product slider end -->
        </div>
    </section>
    <!-- Recent product area end -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện click vào nút "Thêm Giỏ Hàng"
            $('.pro-details-cart a').click(function(e) {
                e.preventDefault(); // Ngừng hành động mặc định của thẻ <a>

                // Lấy ID sản phẩm và số lượng từ giao diện người dùng
                let productId = "{{ $productDetail->id }}"; // ID sản phẩm từ Blade
                let quantity = $('.cart-plus-minus-box').val(); // Số lượng sản phẩm

                // Kiểm tra nếu số lượng hợp lệ
                if (quantity <= 0) {
                    Swal.fire({
                        title: "Thất bại!",
                        text: "Số lượng không hợp lệ!",
                        icon: "error",
                        confirmButtonText: "OK",
                    });

                    return;
                }

                // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
                $.ajax({
                    url: "{{ route('cart.add') }}", // URL của route cart.add
                    method: "POST", // Phương thức POST
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        product_id: productId, // ID sản phẩm
                        quantity: quantity // Số lượng sản phẩm
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
                                updateCartRight();
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
            $('.add-to-cart').off('click').on('click', function(e) {
                e.preventDefault(); // Ngừng hành động mặc định của thẻ <a>

                // Lấy ID sản phẩm và số lượng từ giao diện người dùng
                let productId = $(this).data('product-id');

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
                                updateCartRight();
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Thất bại!",
                                    text: "Không thể tải giỏ hàng, vui lòng thử lại sau!",
                                    icon: "error",
                                    confirmButtonText: "OK",
                                });
                            }
                        });

                        // Hiển thị thông báo thành công
                        Swal.fire({
                            title: "Thành công!",
                            text: "Sản phẩm đã được thêm vào giỏ hàng!",
                            icon: "success",
                            confirmButtonText: "OK",
                        });
                    },
                    error: function(xhr, status, error) {
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
                        console.log(response);
                        $('#cart-right').html(response.cart_html); // Cập nhật phần tử giỏ hàng
                        $('#cart-count').text(response
                            .cart_count); // Cập nhật số lượng sản phẩm trong giỏ hàng
                        $(".item-quantity-tag").text(response
                            .total_quantity); // Cập nhật số lượng sản phẩm bên ngoài giỏ hàng

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
        //comment
        $(document).ready(function() {

            $('#comment-form').on('submit', function(e) {
                e.preventDefault();


                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {

                        const userName = response.user_name;
                        const userAvatar = response.user_avatar;
                        const createdAt = response.created_at;

                        // Thêm bình luận mới vào danh sách bình luận
                        $('#review-wrapper').prepend(`
                    <div class="single-review">
                        <div class="review-img">
                            <img class="rounded-circle" src="${userAvatar}" alt="" width="100" height="100" />
                        </div>
                        <div class="review-content">
                            <div class="review-top-wrap">
                                <div class="review-left">
                                    <div class="review-name">
                                        <h4>${userName}</h4>
                                    </div>
                                    <div class="rating-product">
                                        <small>${createdAt}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="review-bottom">
                                <p>${response.content}</p>
                            </div>
                        </div>
                    </div>
                `);


                        $('#review-count').text(`(${response.count})`);


                        Swal.fire({
                            title: "Thành công!",
                            text: "Bình luận của bạn đã được gửi thành công.",
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(() => {

                            $('#comment-form').parent().html(`
                        <p>Bạn không thể bình luận cho sản phẩm này, hãy mua hàng và để lại đánh giá để cải thiện trải nghiệm mua hàng.</p>
                    `);

                            $('h3:contains("Đánh giá sản phẩm")').hide();
                        });


                        $('#comment-form')[0].reset();
                    },
                    error: function(xhr) {

                        let errorMessage = "Có lỗi xảy ra, vui lòng thử lại sau!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }


                        Swal.fire({
                            title: "Thất bại!",
                            text: errorMessage,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                });
            });
        });
        $(document).ready(function() {
            // Thay đổi ảnh lớn khi nhấp vào ảnh nhỏ
            $('#gallery a').on('click', function() {
                var newImage = $(this).data('image');
                $('#main-image').attr('src', newImage);
                $('#gallery a').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
@endsection

@section('js')
@endsection

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
                        <a href="{{ route('productDetail', ['slug' => $product->slug]) }}" class="thumbnail">
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
                        <a class="inner-link"
                            href="#"><span>{{ $product->ProductCategories?->first()?->category->name }}</span></a>
                        <h2><a href="{{ route('productDetail', ['slug' => $product->slug]) }}"
                                class="product-link">{{ Str::limit($product->name, 20, '...') }}</a></h2>
                        <div class="rating-product">
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                        </div>
                        <div class="pricing-meta">
                            <ul>
                                <li class="old-price">{{ number_format($product->price, 0, '.', '.') }}₫</li>
                                <li class="current-price">{{ number_format($product->sale, 0, '.', '.') }}₫</li>
                                <li class="discount-price">
                                    -{{ round((($product->price - $product->sale) / $product->price) * 100) }}%</li>
                            </ul>
                        </div>
                        <div class="add-to-link">
                            <ul>
                                <li class="cart">
                                    <a href="#" class="cart-btn add-to-cart" data-id="{{ $product->id }}">Thêm
                                        vào giỏ hàng</a>
                                </li>
                                <li><a href="wishlist.html"><i class="ion-android-favorite-outline"></i></a></li>
                                <li><a href="compare.html"><i class="ion-ios-shuffle-strong"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="in-stock">Chỉ còn: <span>{{ $product->quantity }} Sản phẩm</span></div>
                </div>
            </article>
        @endforeach
    </div>
    <!-- Hot Deal Slider 2 End -->
</div>

<!-- Thêm AJAX để xử lý giỏ hàng -->
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
                    // Hiển thị thông báo thành công từ response
                    alert(response.message);

                    $('#cart-count').text(response.cart_count);
                    // Gọi hàm cập nhật giỏ hàng mà không cần reload
                    updateCartRight();
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi người dùng chưa đăng nhập
                    if (xhr.status === 401) {
                        alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
                        window.location.href =
                            "{{ route('login') }}"; // Chuyển hướng đến trang đăng nhập
                    } else {
                        alert('Có lỗi xảy ra: ' + response.message);
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
                    alert('Không thể tải giỏ hàng, vui lòng thử lại.');
                }
            });
        }
    });
</script>

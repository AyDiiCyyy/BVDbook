<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Section Title Start -->
            <div class="section-title">
                <h2>Bán chạy nhất</h2>
                <p>Thêm sản phẩm bán chạy nhất vào giỏ hàng của bạn</p>
            </div>
            <!-- Section Title Start -->
        </div>
    </div>
    <!-- Best Sell Slider Carousel Start -->
    <div class="best-sell-slider owl-carousel owl-nav-style">
        <!-- Single Item -->
        <article class="list-product">
            <div class="img-block">
                <a href="{{ route('productDetail', ['slug' => 'sach-tap-to']) }}" class="thumbnail">
                    <img class="first-img" src="{{ asset('client/assets/images/product-image/organic/test.webp') }}"
                        alt="" />
                    <img class="second-img" src="{{ asset('client/assets/images/product-image/organic/test.webp') }}"
                        alt="" />
                </a>
            </div>
            <ul class="product-flag">
                <li class="new">Mới</li>
            </ul>
            <div class="product-decs">
                <a class="inner-link" href="{{ route('danhmucSanpham', ['slug' => 'danh-muc-cha']) }}"><span>Sách Giáo
                        Khoa</span></a>
                <h2><a href="#" class="product-link">Tiếng Việt Lớp 1</a>
                </h2>
                <div class="pricing-meta">
                    <ul>
                        <li class="old-price">100.000 VND</li>
                        <li class="current-price">50.000 VND</li>
                        <li class="discount-price">-5%</li>
                    </ul>
                </div>
            </div>
            <div class="add-to-link">
                <ul>
                    <li class="cart"><a class="cart-btn add-to-cart" data-id="" href="#">Thêm Vào Giỏ Hàng
                        </a></li>
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
    <!-- Best Sell Slider Carousel End -->
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
                error: function(xhr) {
                    // Xử lý lỗi khi người dùng chưa đăng nhập
                    if (xhr.status === 401) {
                        alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
                        window.location.href =
                            "{{ route('login') }}"; // Chuyển hướng đến trang đăng nhập
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại');
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

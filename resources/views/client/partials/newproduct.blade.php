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
                                <li class="cart"><a class="cart-btn add-to-cart" data-id="{{ $new->id }}"
                                        href="#">Thêm vào giỏ hàng </a></li>
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
                    $('#item-quantity-tag').text(response.total_quantity);
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

<div class="container-fluid">
    <div class="row">

        <!--  Logo Area Start-->
        <div class="col-md-2 col-sm-2">
            <div class="logo">
                <a href="{{ route('index') }}"><img src="{{ asset('client/assets/images/logo/logo5.png') }}" alt=""
                        width="124px" height="34px" /></a>
            </div>
        </div>
        <!--  Logo Area end-->
        <div class="col-md-10 col-sm-10">
            <div class="main-navigation">
                <ul>
                    <li class="menu-dropdown">
                        <a href="{{ route('index') }}">Trang chủ</a>
                    </li>
                    <li class="menu-dropdown">
                        <a href="#">Danh mục <i class="ion-ios-arrow-down"></i></a>
                        <ul class="sub-menu">
                            @foreach ($categoryAll as $category)
                                <li><a
                                        href="{{ route('danhmucSanpham', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="menu-dropdown">
                        <a href="#">Pages <i class="ion-ios-arrow-down"></i></a>
                        <ul class="sub-menu">
                            <li><a href="about.html">About Page</a></li>
                            <li><a href="cart.html">Cart Page</a></li>
                            <li><a href="checkout.html">Checkout Page</a></li>
                            <li><a href="compare.html">Compare Page</a></li>
                            <li><a href="#">Login & Regiter Page</a></li>
                            <li><a href="#">Account Page</a></li>
                            <li><a href="wishlist.html">Wishlist Page</a></li>
                        </ul>
                    </li>
                    <li class="menu-dropdown">
                        <a href="{{ route('about') }}">Giới Thiệu</a>

                    </li>
                    <li><a href="{{ route('contact.index') }}">Liên Hệ</a></li>
                </ul>
            </div>
            <!-- Main Navigation Area end -->
            <div class="header_account_area ">
                <div class="header_account_list me-2">
                </div>
                <!-- Search start -->
                <div class="header_account_list search_list" style="height: auto">
                    <a href="javascript:void(0)"><i class="ion-ios-search-strong"></i></a>
                    <div class="dropdown_search">
                        <form action="#">
                            <input placeholder="Bạn cần tìm gì..." type="text" />
                            <div class="search-category">
                                <select class="bootstrap-select" name="poscats">
                                    <option value="0">Danh mục</option>
                                    @foreach ($categoryAll as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"><i class="ion-ios-search-strong"></i></button>
                        </form>
                    </div>
                </div>
                <!-- Search  End -->
                <!-- cart info start  -->
                <div class="cart-info d-flex">
                    <div class="mini-cart-warp">
                        <a href="#offcanvas-cart" class="count-cart color-white offcanvas-toggle">
                            <span class="item-quantity-tag">{{ $totalQuantity ?? 0 }}</span>
                        </a>

                    </div>
                </div>
                <!-- cart info  End -->
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateCartQuantity() {
        $.ajax({
            url: '{{ route('cart.quantity') }}',
            method: 'GET',
            success: function(response) {
                $('.item-quantity-tag').text(response.total_quantity);
                updateCartQuantity(); // Cập nhật số lượng ngay sau khi thêm
            },
            error: function() {
                console.error('Không thể cập nhật số lượng giỏ hàng');
            }
        });
    }

    // Gọi hàm cập nhật khi cần thiết, ví dụ khi thêm sản phẩm vào giỏ hàng thành công
    $(document).ready(function() {
        updateCartQuantity(); // Cập nhật ngay khi load trang
    });
</script>

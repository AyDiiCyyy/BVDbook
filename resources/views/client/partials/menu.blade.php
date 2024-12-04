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
               

                            @guest
                            <div class="header-top-set-lan-curr d-flex mt-2">
                                <div class="header-bottom-set dropdown">
                                <!-- Hiển thị Login khi chưa đăng nhập -->
                                <a href="{{ route('login') }}"
                                class="hover-style-default color-white border-color-white"> <i class="bi bi-person fs-2"></i></a>
                            
                            @endguest

                            @auth
                            <div class="header-top-set-lan-curr d-flex mt-3">
                                <div class="header-bottom-set dropdown">
                                <!-- Hiển thị Logout khi đã đăng nhập -->
                                <a
                            class="dropdown-toggle  hover-style-default color-white border-color-white fs-6 "
                            data-bs-toggle="dropdown"><i class="bi bi-person me-1"></i>{{ Auth::user()->name }} </a>
                        <ul class="dropdown-menu mt-2 ms-4">
                            <li><a class="dropdown-item" href="{{ route('my-account') }}">Tài Khoản</a></li>
                            <li><a class="dropdown-item" href="#">Thanh toán</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Đăng Xuất') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>

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

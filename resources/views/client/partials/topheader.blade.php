<div class="header-top-nav">
    <div class="container-fluid">
        <div class="row align-items-center">
            <!--Left Start-->
            <div class="col-lg-4 col-md-12">
                <div class="text-lg-start text-center">
                    <p class="color-black">Chào mừng bạn đến với BVD Book!!!</p>
                </div>
            </div>
            <!--Left End-->
            <!--Right Start-->
            <div class="col-8 d-lg-block d-none">
                <div class="header-right-nav">
                    <ul>
                        <li class="border-color-black">
                            <a href="wishlist.html"><i class="ion-android-favorite-outline"></i>Sản phẩm yêu thích
                                (0)</a>
                        </li>
                    </ul>
                    <!-- Header Top Language Currency -->
                    <div class="header-top-set-lan-curr d-flex justify-content-end">
                        <div class="header-bottom-set dropdown">
                            <button
                                class="dropdown-toggle header-action-btn hover-style-default color-black border-color-black"
                                data-bs-toggle="dropdown"> Settings <i class="ion-ios-arrow-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('my-account') }}">Tài Khoản</a></li>
                                <li><a class="dropdown-item" href="#">Thanh toán</a></li>

                                @guest
                                    <!-- Hiển thị Login khi chưa đăng nhập -->
                                    <li><a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                @endguest

                                @auth
                                    <!-- Hiển thị Logout khi đã đăng nhập -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                    <!-- Header Top Language Currency -->
                </div>
            </div>
            <!--Right End-->
        </div>
    </div>
</div>

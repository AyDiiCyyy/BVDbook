<div class="container-fluid">
    <div class="row">

        <!--  Logo Area Start-->
        <div class="col-md-2 col-sm-2">
            <div class="logo">
                <a href="index.html"><img src="{{ asset('client/assets/images/logo/logo-3.jpg') }}" alt="" /></a>
            </div>
        </div>
        <!--  Logo Area end-->
        <div class="col-md-10 col-sm-10">
            <div class="main-navigation">
                <ul>
                    <li class="menu-dropdown">
                        <a href="#">Trang chủ</a>
                    </li>
                    <li class="menu-dropdown">
                        <a href="#">Danh mục <i class="ion-ios-arrow-down"></i></a>
                        <ul class="sub-menu">
                            @foreach ($categoryAll as $category) 
                            <li><a href="{{ route('danhmucSanpham', ['slug'=>$category->slug]) }}">{{$category->name}}</a></li>
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
                            <li><a href="login.html">Login & Regiter Page</a></li>
                            <li><a href="my-account.html">Account Page</a></li>
                            <li><a href="wishlist.html">Wishlist Page</a></li>
                        </ul>
                    </li>
                    <li class="menu-dropdown">
                        <a href="#">Giới Thiệu</a>
                        
                    </li>
                    <li><a href="contact.html">Liên hệ</a></li>
                </ul>
            </div>
            <!-- Main Navigation Area end -->
            <div class="header_account_area">
                <!-- Search start -->
                <div class="header_account_list search_list">
                    <a href="javascript:void(0)"><i class="ion-ios-search-strong"></i></a>
                    <div class="dropdown_search">
                        <form action="#">
                            <input placeholder="Bạn cần tìm gì..." type="text" />
                            <div class="search-category">
                                <select class="bootstrap-select" name="poscats">
                                    <option value="0">Danh mục</option>
                                    @foreach ($categoryAll as $category )
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach​
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
                            <span class="item-quantity-tag">02</span>
                        </a>

                    </div>
                </div>
                <!-- cart info  End -->
            </div>
        </div>
    </div>

</div>

<!DOCTYPE html>
<html lang="en">


<head>
    @include('client.partials.head')
</head>

<body class="home-3">

    <!--====== PRELOADER PART ENDS ======-->
    <div id="main">
        <!-- Header Area Start  -->
        <header class="main-header">
            <!-- Header top Area Start  -->
                @include('client.partials.topheader')
            <!-- Header top Area end  -->

            <!-- Header Navigation Area Start  -->
            <div class="header-navigation sticky-nav d-none d-lg-block">
                <!--  Logo And Menu-->
                    @include('client.partials.menu')
                <!--  Logo And Menu end-->
            </div>
            <!--Header Bottom Account End -->

        </header>
        <!-- Header End -->

        <!-- offcanvas overlay start -->
        <div class="offcanvas-overlay"></div>
        <!-- offcanvas overlay end -->
        <!-- OffCanvas Cart Start -->
        <div id="offcanvas-cart" class="offcanvas offcanvas-cart hover-style-default">
            @include('client.partials.cartright')
        </div>
        <!-- OffCanvas Cart End -->
        <!--  Main Header End -->

        @yield('content')

        <!-- SAU KHI CÓ ROUTER THÌ CẮT PHẦN DƯỚI ĐÂY ĐI -->

        <!-- Slider Arae Start -->
        <div class="slider-area">
            <!-- Slider Single Item Start -->
                @include('client.partials.slider')
            <!-- Slider Single Item End -->
        </div>
        <!-- Slider Arae End -->
        <!-- Banner Area Start -->
        <div class="banner-3-area">
            @include('client.partials.banner')
        </div>
        <!-- Banner Area End -->
        <!-- Static Area Start -->
        <section class="static-area mtb-60px">
            @include('client.partials.static')
        </section>
        <!-- Static Area End -->
        <!-- Best Sells Area Start -->
        <section class="best-sells-area">
            @yield('bestseller')
            @include('client.partials.bestseller')
        </section>
        <!-- Best Sell Area End -->
        <!-- Feature Area 2 Start -->
        <section class="feature-area-2">
                @yield('feature')
                @include('client.partials.feature')
        </section>
        <!-- Feature area 2 End -->

        <!-- Hot deal area Start -->
        <section class="hot-deal-area">
            @yield('hotdeal')
            @include('client.partials.hotdeal')
        </section>
        <!-- Hot Deal Area End -->
        <!-- Recent Add Product Area Start -->
        <section class="recent-add-area">
            @yield('products')
            @include('client.partials.newproduct')
        </section>
        <!-- Recent product area end -->
        <!-- Blog area Start -->
        <section class="blog-area mb-30px">
            @include('client.partials.blog')
        </section>
        <!-- Blog Area End -->
        <!-- Category Area Start -->
        <section class="categorie-area">
            @yield('categories')
            @include('client.partials.categories')
        </section>
        <!-- Category Area End -->

        <!-- CẮT ĐẾN ĐÂY -->

        <!-- Footer Area start -->
        <footer class="footer-area">
            @include('client.partials.footer')
        </footer>
        <!--  Footer Area End -->
    </div>

    <!-- Modal (product show) -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        @include('client.partials.productshow')

    </div>
    <!-- Modal end -->

    @include('client.partials.js')
</body>


</html>

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

    

    @include('client.partials.js')
</body>


</html>

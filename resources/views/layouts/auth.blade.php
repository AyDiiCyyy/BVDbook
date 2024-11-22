<!DOCTYPE html>
<html lang="en">
<head>
    @include('client.partials.head') 
    <title>@yield('title', 'Login')</title>
</head>
<body>   
    <div id="main">

        <!-- offcanvas overlay start -->
        <div class="offcanvas-overlay"></div>
        <!-- offcanvas overlay end -->

        <!--  Main Header End -->

        @yield('content')



    </div>

    <!-- Thêm các phần cần thiết khác như JavaScript -->
    @include('client.partials.js')
</body>
</html>

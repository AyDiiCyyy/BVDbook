<!DOCTYPE html>
<html lang="en">
<head>
    @include('client.partials.head') 
    <title>@yield('title', 'Login')</title>
    <meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>BVD Book Login</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/login/css/bootstrap.min.css')}}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/login/css/fontawesome-all.min.css')}}">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/login/font/flaticon.css')}}">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('assets/login/style.css')}}">
</head>
<body>   

    <div id="main">


        @yield('content')



    </div>

    <!-- Thêm các phần cần thiết khác như JavaScript -->
    @include('client.partials.js')
</body>
<script src="{{ asset('assets/login/js/jquery.min.js')}}"></script>
	<!-- Bootstrap js -->
	<script src="{{ asset('assets/login/js/bootstrap.min.js')}}"></script>
	<!-- Imagesloaded js -->
	<script src="{{ asset('assets/login/js/imagesloaded.pkgd.min.js')}}"></script>
	<!-- Validator js -->
	<script src="{{ asset('assets/login/js/validator.min.js')}}"></script>
	<!-- Custom Js -->
	<script src="{{ asset('assets/login/js/main.js')}}"></script>
    
</html>

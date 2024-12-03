<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('client/assets/images/favicon/favicon.png') }}" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800&amp;display=swap" rel="stylesheet" />


<link rel="stylesheet" href="{{ asset('client/assets/css/vendor/vendor.min.css') }}">
<link rel="stylesheet" href="{{ asset('client/assets/css/plugins/plugins.min.css') }}">
<link rel="stylesheet" href="{{ asset('client/assets/css/style.min.css') }}">
<link rel="stylesheet" href="{{ asset('client/assets/css/responsive.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .search-category .nice-select .list {
        height: 300px;
    }
</style>

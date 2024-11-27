@extends('client.layouts')

@section('title')
    Trang Chủ
@endsection

@section('content')
    <!-- Slider Arae Start -->
    <div class="slider-area">
        <!-- Slider Single Item Start -->
        @include('client.partials.my-account')
        <!-- Slider Single Item End -->
    </div>
@endsection

@extends('client.layouts')

@section('title')
    Trang Chủ
@endsection

@section('content')
    <!-- Slider Arae Start -->
    <div class="slider-area">
        <!-- Slider Single Item Start -->
        @include('client.partials.slider')
        <!-- Slider Single Item End -->
    </div>
    <!-- Slider Arae End -->
    <!-- Banner Area Start -->
    {{-- <div class="banner-3-area">
        @include('client.partials.banner')
    </div> --}}
    <!-- Banner Area End -->
    <!-- Static Area Start -->
    <section class="static-area mtb-60px">
        @include('client.partials.static')
    </section>
    <!-- Static Area End -->
    <!-- Best Sells Area Start -->
    <section class="best-sells-area">
        @include('client.partials.bestseller')
    </section>
    <!-- Best Sell Area End -->
    <!-- Feature Area 2 Start -->
    <section class="feature-area-2">
        @include('client.partials.feature')
    </section>
    <!-- Feature area 2 End -->

    <!-- Hot deal area Start -->
    <section class="hot-deal-area">
        @include('client.partials.hotdeal')
    </section>
    <!-- Hot Deal Area End -->
    <!-- Recent Add Product Area Start -->
    <section class="recent-add-area">
        @include('client.partials.newproduct')
    </section>
    <!-- Recent product area end -->
    <!-- Blog area Start -->
    {{-- <section class="blog-area mb-30px">
        @include('client.partials.blog')
    </section> --}}
    <!-- Blog Area End -->
    <!-- Category Area Start -->
    <section class="categorie-area">
        @include('client.partials.categories')
    </section>
    <!-- Category Area End -->
@endsection

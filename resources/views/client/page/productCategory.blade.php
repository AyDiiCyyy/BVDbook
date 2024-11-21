@extends('client.layouts')

@section('title')
    Danh mục sản phẩm
@endsection

@section('content')
    {{-- breadcrumb-area --}}
    @include('client.partials.breadcrumb-area');


    <!-- Shop Category Area -->
    <div class="shop-category-area">
    @include('client.partials.product_category_area');
    </div>
@endsection

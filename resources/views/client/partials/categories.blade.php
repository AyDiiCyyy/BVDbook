<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Section Title -->
            <div class="section-title">
                <h2>Danh mục phổ biến</h2>
                <p>Thêm các sản phẩm thuộc danh mục phổ biến vào giỏ hàng của bạn
                </p>
            </div>
            <!-- Section Title -->
        </div>
    </div>
    <!-- Category Slider Start -->
    <div class="category-slider owl-carousel owl-nav-style">
        <!-- Single item -->
        @foreach ($categories as $category)
        <div class="category-item">
            @foreach ($category as $item )
            <div class="category-list {{ $loop->first ? 'mb-30px' : '' }}">
                <div class="category-thumb">
                    <a href="{{ route('danhmucSanpham', ['slug'=>$item->slug]) }}">
                        @if ($item->image!='')
                        <img src="{{ asset('storage').'/'.$item->image }}" alt="" />
                        @else
                        <img src="{{ asset('storage/uploads/categories/1733812164_Group 1.png') }}" alt="" />
                        @endif
                    </a>
                </div>
                <div class="desc-listcategoreis">
                    <div class="name_categories">
                        <h4>{{$item->name}}</h4>
                    </div>
                    <span class="number_product">{{$item->product_count}} sản phẩm</span>
                    <a href="{{ route('danhmucSanpham', ['slug'=>$item->slug]) }}"> Mua ngay <i
                            class="ion-android-arrow-dropright-circle"></i></a>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
    <!-- Category Slider Start -->
</div>
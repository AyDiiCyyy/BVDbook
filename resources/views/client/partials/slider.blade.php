<div class="slider-active-3 owl-carousel slider-hm8 owl-dot-style">
    @foreach ($slide as $item)
        <a href="{{ asset('danhmuc').'/'.$item->slug }}" class="slider-link"> <!-- Thêm thẻ a ở đây -->
            <div class="slider-height-6 d-flex align-items-start justify-content-start bg-img"
                style="background-image: url({{ asset($item->image) }});">
            </div>
        </a>
    @endforeach
</div>

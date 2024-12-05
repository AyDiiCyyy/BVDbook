<div class="slider-active-3 owl-carousel slider-hm8 owl-dot-style">
    @foreach ($slide as $item)
        <div class="slider-height-6 d-flex align-items-start justify-content-start bg-img"
            style="background-image: url({{ asset($item->image) }});">
        </div>
    @endforeach
</div>

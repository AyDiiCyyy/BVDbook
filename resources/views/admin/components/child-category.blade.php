@foreach ($children as $child)
    @if (isset($cate->id))
        @if ($child->id != $cate->id)
            <option  value="{{ $child->id }}" 
                @selected(in_array($child->id, old('parent_id[]',($cateData??[]))))
                @selected($child->id==old('parent_id',($cateData1)))
            >
                {{ str_repeat('-', $depth) }} {{ $child->name }}</option>
        @else
            @continue
        @endif
    @else
        <option  value="{{ $child->id }}" 
            @selected(in_array($child->id, old('categories',($cateData??[]))))
            {{-- @selected($child->id==old('parent_id')) --}}
        >
            {{ str_repeat('-', $depth) }} {{ $child->name }}</option>
    @endif

    @if (count($child->childrenRecursive) > 0)
        @include('admin.components.child-category', [
            'children' => $child->childrenRecursive,
            'depth' => $depth + 1,
        ])
    @endif
@endforeach

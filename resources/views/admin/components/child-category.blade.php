@foreach ($children as $child)
    @if (isset($cate->id) && $child->id != $cate->id)
        <option value="{{ $child->id }}" 
            @selected(in_array($child->id, old('parent_id[]', ($cateData ?? []))))
            @selected($child->id == old('parent_id', ($cateData1 ?? null)))
        >
            {{ str_repeat('-', $depth) }} {{ $child->name }}
        </option>
    @elseif (!isset($cate->id))
        <option value="{{ $child->id }}" 
            @selected(in_array($child->id, old('parent_id[]', ($cateData ?? []))))
            @selected($child->id == old('parent_id'))
        >
            {{ str_repeat('-', $depth) }} {{ $child->name }}
        </option>
    @endif

    @if ($child->childrenRecursive->isNotEmpty())
        @include('admin.components.child-category', [
            'children' => $child->childrenRecursive,
            'depth' => $depth + 1,
        ])
    @endif
@endforeach

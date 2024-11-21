@extends('layouts.admin')
@section('title')
@endsection
@section('css')
@endsection
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $title }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <form method="POST" action="{{ route('admin.category.update', $category->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                {{-- <div class="mb-3">
                                    <label class="form-label">Danh mục cha: </label>
                                    <select name="parent_id" id="parent_category" class="form-select">
                                        <option value="">Chọn danh mục cha</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}" 
                                                {{ $category->parent_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                            @if ($item->childrenRecursive->isNotEmpty())
                                                @include('admin.components.child-category', [
                                                    'children' => $item->childrenRecursive,
                                                    'depth' => 1,
                                                    'selectedParentId' => $category->parent_id
                                                ])
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                        
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục: </label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" onkeyup="ChangeToSlug()" id="slug">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                <div class="mb-3">
                                    <label class="form-label">Slug danh mục: </label>
                                    <input type="text" class="form-control" name="slug" value="{{ old('slug', $category->slug) }}" id="convert_slug">
                                    @error('slug')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                <div class="mb-3">
                                    <label class="form-label">Ảnh danh mục: </label>
                                    <input type="file" class="form-control" name="image">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid mt-2" style="max-height: 150px;">
                                    @endif
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')
<script type="text/javascript">
    function ChangeToSlug() {
        var slug;

        // Lấy text từ thẻ input tên danh mục
        slug = document.getElementById("slug").value;
        slug = slug.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        
        // Đưa slug ra textbox có id “slug”
        document.getElementById('convert_slug').value = slug;
    }
</script>
@endsection

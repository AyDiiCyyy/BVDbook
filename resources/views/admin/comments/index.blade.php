@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Danh sách bình luận</h3>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">User</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->user->name }}</td> 
                            <td>{{ $comment->product->name }}</td> 
                            <td>{{ $comment->content }}</td>
                            <td class="d-flex justify-content-center">
                                @if($comment->deleted_at)
                                    <!-- Button Khôi phục -->
                                    {{-- <form action="{{ route('admin.comments.restore', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Khôi phục</button>
                                    </form> --}}
                                @else
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $comments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

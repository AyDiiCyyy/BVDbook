@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quản lý Bình luận</h1>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Sản phẩm</th>
                    <th>Nội dung</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->user->name }}</td> 
                    <td>{{ $comment->product->name }}</td> 
                    <td>{{ $comment->content }}</td>
                    <td>
                        @if($comment->deleted_at)
                            <form action="{{ route('admin.comments.restore', $comment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">Khôi phục</button>
                            </form>
                        @else
                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
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

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $comments->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

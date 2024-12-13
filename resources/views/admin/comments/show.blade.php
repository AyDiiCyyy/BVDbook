@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Danh sách bình luận</h3>
    <form method="GET" action="{{ route('admin.comments.show', $product->id) }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="date" name="filter_date" class="form-control" placeholder="Chọn ngày" value="{{ request('filter_date') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">User name</th>
                            <th scope="col">Ngày bình luận</th>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                        <tr>
                    
                            <td> {{ $comment->User->name }}</td> 
                            <td>{{ $comment->created_at->format('d-m-Y') }}</td> 
                            <td>{{ $comment->content}}</td> 
                            <td class="d-flex justify-content-center">
                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này?')">Xóa</button>
                                </form>
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

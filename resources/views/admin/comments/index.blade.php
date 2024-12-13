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
                    <thead class="thead-dark text-center align-middle">
                        <tr>
                            {{-- <th scope="col">ID</th> --}}
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng bình luận</th>
                          
                            <th scope="col" class="d-flex justify-content-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle">
                        @foreach($products as $comment)
                        <tr>
                    
                            <td><a class="text-decoration-none text-dark" href="{{ route('productDetail', ['slug' => $comment->slug ]) }}"> {{ $comment->name }}</a></td> 
                            <td>{{ $comment->comments_count }} <i class="bi bi-chat-text"></i></td> 
                        
                            <td class="d-flex justify-content-center">
                             <a href="{{route('admin.comments.show', $comment->id)}}"> <button class="btn btn-success"> Xem chi tiết</button></a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Sửa người dùng')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Sửa thông tin người dùng</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('admin.user.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
    
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Số điện thoại:</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" >
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ảnh đại diện:</label>
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="img-fluid mt-2" style="max-height: 150px;">
                    @endif
                    @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                @if ($user->role != 0) <!-- Kiểm tra nếu người dùng không phải là admin -->
                    <div class="mb-3">
                        <label class="form-label">Vai trò:</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Người dùng</option>
                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</main>
@endsection
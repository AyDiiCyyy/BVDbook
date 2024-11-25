<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh sách người dùng";
        
        // Lấy từ khóa tìm kiếm từ request
        $search = $request->input('search');
    
        // Lấy danh sách người dùng với phân trang và tìm kiếm
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10); // Phân trang 10 tài khoản mỗi trang
    
        return view('admin.users.index', compact('title', 'users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);
    if ($user->role==1){
        $data = [
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role, // Nếu bạn muốn cập nhật vai trò
        ];
    }else{
        $data = [
            'email' => $request->email,
            'phone' => $request->phone,
        ];
    }
     
        // Xử lý ảnh đại diện
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            if ($avatar->isValid()) {
                if ($user->avatar) {
                    Storage::delete($user->avatar);
                }
                $data['avatar'] = $avatar->store('avatars', 'public');
            } else {
                return back()->withErrors(['avatar' => 'Ảnh đại diện không hợp lệ']);
            }
        }
        $user->update($data);
    
        return redirect()->route('admin.user.index')->with('status_succeed', 'Cập nhật thông tin người dùng thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function changeActive(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->active = $request->status;
            $user->save();
    
            return response()->json(['active' => $user->active]);
        }
    
        return response()->json(['error' => 'User  not found'], 404);
    }
}

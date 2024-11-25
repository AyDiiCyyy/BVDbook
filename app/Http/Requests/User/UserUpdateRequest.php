<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('id'),
            'phone' => 'required|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'nullable|in:0,1', // 0: Admin, 1: Người dùng
        ];
    }

    public function messages()
    {
        return [
          
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'avatar.image' => 'Ảnh đại diện phải là một ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'role.in' => 'Vai trò không hợp lệ.',
        ];
    }
}


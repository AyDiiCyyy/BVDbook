<?php

namespace App\Http\Requests\Slide;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255', 
            "image" => "nullable|file|mimes:jpeg,jpg,png,svg,webp|max:4048",
            "order" => "required|integer|min:1|max:1000"
        ];
    }

    public function messages()
    {
        return [
            // Name
            "name.required" => "Tên slide bắt buộc nhập",
            "name.min" => "Tên slide phải lớn hơn 1 kí tự",
            "name.max" => "Tên slide phải nhỏ hơn 255 kí tự",

            "image.file" => "Ảnh silde không đúng định dạng",
            "image.mimes" =>"Ảnh silde không đúng định dạng jpeg,jpg,png,svg,webp",
            "image.max" => "Dung lượng ảnh phải nhỏ hơn 2MB", 

            "order.required" => "Số thứ tự bắt buộc nhập",
            "order.integer" => "Số thứ tự phải là số nguyên",
            "order.max" => "Số thứ tự phải nhỏ hơn 1000",
            "order.min" => "Số thứ tự phải lớn hơn 1",
            
        ];
    }
}

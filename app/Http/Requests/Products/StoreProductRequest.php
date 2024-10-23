<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            // "name" => "required|min:1|max:250",
            // 'price' => "required|numeric|min:0|max:99999999.99",
            // 'sale' => "nullable|numeric|min:0|max:99999999.99|lt:price",
            // "slug" => [
            //     'required',
            //     Rule::unique('products', 'slug')->whereNull('deleted_at'),
            // ],
            // "image" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:2048",
            
            // đã xong



            // "order" => "nullable|numeric",
            // "language_id" => "required|numeric",
            // 'parent_id' => 'required',
            // 'code' => [
            //     'required',
            //     Rule::unique('products', 'code')->whereNull('deleted_at'),
            // ],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Tên sản phẩm bắt buộc nhập",
            "name.min" => "Tên sản phẩm > 1 kí tự",
            "name.max" => "Tên sản phẩm < 250 kí tự",

            "price.required" => "Giá sản phẩm bắt buộc nhập",
            "price.numeric" => "Giá sản phẩm phải là số",
            "price.min" => "Giá sản phẩm phải lớn hơn 0",
            "price.max" => "Giá sản phẩm phải nhỏ hơn 99999999.99",


            "sale.numeric" => "Giá khuyến mãi phải là số",
            "sale.numeric" => "Giá khuyến mãi phải là số",
            "sale.min" => "Giá khuyến mãi phải lớn hơn 0",
            "sale.max" => "Giá khuyến mãi phải nhỏ hơn 99999999.99",
            "sale.lt" => "Giá khuyến mãi phải nhỏ hơn giá gốc",

            "slug.required" => "Đường dẫn bắt buộc nhập",
            "slug.unique" => "Đường dẫn đã tồn tại",

            "image.mimes" => "Ảnh đại diện phải là định dạng jpeg,jpg,png,svg,webp <= 2MB",
            "image.max" => "Kích cỡ ảnh đại diện phải nhỏ hơn < 2MB",

            // "order.numberic" => "Sắp xếp phải là số",
            // 'language_id.required' => "Ngôn ngữ bắt buộc chọn",
            // 'language_id.numberic' => "Ngôn ngữ sai định dạng",
            // 'parent_id.required' => 'Phải chọn ít nhất 1 danh mục',
            // 'code.unique' => 'Mã sản phẩm đã tồn tại',
        ];
    }
}

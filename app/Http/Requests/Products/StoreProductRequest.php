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
            "name" => "required|min:1|max:255",
            "slug" => [
                'required',
                Rule::unique('products', 'slug')->whereNull('deleted_at')],
            "sku" => [
                'required',
                Rule::unique('products', 'sku')->whereNull('deleted_at')],
            "price" => "required|min:0|max:99999999,99|numeric",            
            "sale" => "nullable|numeric|min:0|max:99999999,99|lt:price",
            "image" => "nullable|file|mimes:jpeg,jpg,png,svg,webp|max:2048",
            "categories" => "required",
            "author" => "required|string|min:1|max:255",
            "publisher" => "required|string|min:1|max:255",
            "released" => "required|integer|max:". date('Y'),
            "weight" => "required|numeric|max:1000",
            "page" => "required|integer|min:1|max:10000",
            "quantity" => "required|integer|min:0|max:100000",
            "product_image" => "nullable|array",
            "product_image.*" => "file|mimes:jpeg,jpg,png,svg,webp|max:2048",
            "order" => "required|integer|min:1|max:1000"
        ];
    }

    public function messages()
    {
        return [
            // Name
            "name.required" => "Tên sản phẩm bắt buộc nhập",
            "name.min" => "Tên sản phẩm phải lớn hơn 1 kí tự",
            "name.max" => "Tên sản phẩm phải nhỏ hơn 255 kí tự",

            "slug.required" => "Đường dẫn bắt buộc nhập",
            "slug.unique" => "Đường dẫn đã tồn tại",

            "sku.required" => "Mã sản phẩm bắt buộc nhập",
            "sku.unique" => "Mã sản phẩm đã tồn tại",

            "price.required" => "Giá sản phẩm bắt buộc nhập",
            "price.min" => "Giá sản phẩm phải lớn hơn 0",
            "price.max" => "Giá sản phẩm phải nhỏ hơn 99999999,99",
            "price.numeric" => "Giá sản phẩm phải là số",

            "sale.numeric" => "Giá khuyến mãi phải là số",
            "sale.min" => "Giá khuyến mãi phải lớn hơn 0",
            "sale.max" => "Giá khuyến mãi phải nhỏ hơn 99999999,99",
            "sale.lt" => "Giá khuyến mãi phải nhỏ hơn giá sản phẩm",

            "image.file" => "Ảnh đại diện không đúng định dạng",
            "image.mimes" =>"Ảnh đại diện không đúng định dạng jpeg,jpg,png,svg,webp",
            "image.max" => "Dung lượng ảnh phải nhỏ hơn 2MB", 

            "categories" => "Danh mục bắt buộc phải chọn",

            "author.required" => "Tên tác giả bắt buộc nhập",
            "author.string" => "Tên tác giả phải là chuỗi", 
            "author.min" => "Tên tác giả phải lớn hơn 1 kí tự",
            "author.max" => "Tên tác giả phải nhỏ hơn 255 kí tự",

            "publisher.required" => "Tên nhà xuất bản bắt buộc nhập",
            "publisher.string" => "Tên nhà xuất bản phải là chuỗi", 
            "publisher.min" => "Tên nhà xuất bản phải lớn hơn 1 kí tự",
            "publisher.max" => "Tên nhà xuất bản phải nhỏ hơn 255 kí tự",

            "released.required" => "Năm xuất bản bắt buộc nhập",
            "released.numeric" => "Năm xuất bản phải là số",
            "released.max" => "Năm xuất bản phải nhỏ hơn năm hiện tại", 

            "weight.required" => "Cân nặng bắt buộc nhập",
            "weight.numeric" => "Cân nặng phải là số",
            "weight.max" => "Cân nặng phải nhỏ hơn 1000", 

            "page.required" => "Số trang bắt buộc nhập", 
            "page.integer" => "Số trang phải là số nguyên",
            "page.min" => "Số trang phải lớn hơn 1",
            "page.max" => "Số trang phải nhỏ hơn 10000",

            "quantity.required" => "Số lượng bắt buộc nhập",
            "quantity.integer" => "Số lượng phải là số nguyên",
            "quantity.min" => "Số lượng phải lơnn hơn 0",
            "quantity.max" => "Số lượng phải nhỏ hơn 100000",

            "product_image.array" => "Ảnh liên quan phải là 1 mảng",
            "product_image.*.mimes" => "Ảnh liên quan không đúng định dạng jpeg,jpg,png,svg,webp",
            "product_image.*.file" => "Ảnh liên quan không đúng định dạng",
            "product_image.*.max" => "Dung lượng ảnh liên quan phải nhỏ hơn 2MB",

            "order.required" => "Số thứ tự bắt buộc nhập",
            "order.integer" => "Số thứ tự phải là số nguyên",
            "order.max" => "Số thứ tự phải nhỏ hơn 1000",
            "order.min" => "Số thứ tự phải lớn hơn 1",
            
        ];
    }
}

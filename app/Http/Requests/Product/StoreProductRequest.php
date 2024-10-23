<?php

namespace App\Http\Requests\Product;

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
            "name" => "required|min:1|max:250",
            "slug" => [
                'required',
                Rule::unique('products', 'slug')->whereNull('deleted_at'),
            ],
            "price" => "required|numeric|min:0|max:99999999.99",
            "sale" => "nullable|numeric|min:0|max:99999999.99|lt:price",
            "short_description" => "required|string|max:500",
            "long_description" => "required|string|max:10000",
            "author" => "required|string|min:5|max:250",
            "publisher" => "required|string|min:5|max:250",
            "image" => "nullable|file|mimes:jpeg,jpg,png,svg,webp|max:2048",
            "released" => "required|integer|min:0",
            "weight" => "required|string|max:100",
            "page" => "required|integer|min:1|max:10000",
            "quantity" => "required|integer|min:0|max:100000",
            "categories" => "required",
            "product_image" => "nullable|file|mimes:jpeg,jpg,png,svg,webp|max:2048",


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
            //Name
            "name.required" => "Tên sản phẩm bắt buộc nhập",
            "name.min" => "Tên sản phẩm lớn hơn 1 kí tự",
            "name.max" => "Tên sản phẩm không được vượt quá 250 kí tự",
            //Slug
            "slug.required" => "Đường dẫn bắt buộc nhập",
            "slug.unique" => "Đường dẫn đã tồn tại",
            //Price
            "price.required" => "Giá sản phẩm bắt buộc nhập",
            "price.numeric" => "Giá sản phẩm phải là số",
            "price.min" => "Giá sản phẩm phải lớn hơn 0",
            "price.max" => "Giá sản phẩm phải nhỏ hơn 99999999.99",
            //Sale
            "sale.numeric" => "Giá khuyến mãi phải là số",
            "sale.numeric" => "Giá khuyến mãi phải là số",
            "sale.min" => "Giá khuyến mãi phải lớn hơn 0",
            "sale.max" => "Giá khuyến mãi phải nhỏ hơn 99999999.99",
            "sale.lt" => "Giá khuyến mãi phải nhỏ hơn giá gốc",
            //Short description
            "short_description.required" => "Mô tả ngắn bắt buộc nhập.",
            "short_description.string" => "Mô tả ngắn phải là chuỗi ký tự.",
            "short_description.max" => "Mô tả ngắn không được vượt quá 500 ký tự.",
           
            //Long description
            "long_description.required" => "Mô tả chi tiết bắt buộc nhập.",
            "long_description.string" => "Mô tả chi tiết phải là chuỗi ký tự.",
            "long_description.max" => "Mô tả chi tiết không được vượt quá 10,000 ký tự.",
            //Author
            "author.required" => "Tác giả bắt buộc nhập.",
            "author.string" => "Tác giả phải là chuỗi ký tự.",
            "author.min" => "Tác giả lớn hơn 5 kí tự.",
            "author.max" => "Tên tác giả không được vượt quá 250 ký tự.",
            //Publisher
            "publisher.required" => "Nhà xuất bản bắt buộc nhập.",
            "publisher.string" => "Nhà xuất bản phải là chuỗi ký tự.",
            "publisher.min" => "Nhà xuất lớn hơn 5 kí tự.",
            "publisher.max" => "Tên nhà xuất bản không được vượt quá 250 ký tự.",
            //Image 
            "image.mimes" => "Ảnh đại diện phải là định dạng jpeg,jpg,png,svg,webp <= 2MB",
            "image.max" => "Kích cỡ ảnh đại diện phải nhỏ hơn < 2MB",
            //Released
            "released.required" => "Năm phát hành bắt buộc nhập.",
            "released.integer" => "Năm phát hành phải là số nguyên.",
            "released.min" => "Năm phát hành phải lớn hơn hoặc bằng 0.",
            //Weight
            "weight.required" => "Khối lượng bắt buộc nhập.",
            "weight.string" => "Khối lượng phải là chuỗi ký tự.",
            "weight.max" => "Khối lượng không được vượt quá 100 ký tự.",
            //Page
            "page.required" => "Số trang bắt buộc nhập.",
            "page.integer" => "Số trang phải là số nguyên.",
            "page.min" => "Số trang phải lớn hơn hoặc bằng 1.",
            "page.max" => "Số trang không được vượt quá 10,000.",
            //Quantity
            "quantity.required" => "Số lượng bắt buộc nhập.",
            "quantity.integer" => "Số lượng phải là số nguyên.",
            "quantity.min" => "Số lượng phải lớn hơn hoặc bằng 0.",
            "quantity.max" => "Số lượng không được vượt quá 100,000.",
            //Categories
            "categories.required" => "Phải chọn ít nhất 1 danh mục.",
            //Product_image
            "product_image.mimes" => "Ảnh sản phẩm phải là định dạng jpeg,jpg,png,svg,webp <= 2MB",
            "product_image.max" => "Kích cỡ ảnh sản phẩm phải nhỏ hơn < 2MB",
           
          

        




            // "order.numberic" => "Sắp xếp phải là số",
            // 'language_id.required' => "Ngôn ngữ bắt buộc chọn",
            // 'language_id.numberic' => "Ngôn ngữ sai định dạng",
            // 'parent_id.required' => 'Phải chọn ít nhất 1 danh mục',
            // 'code.unique' => 'Mã sản phẩm đã tồn tại',
        ];
    }
}

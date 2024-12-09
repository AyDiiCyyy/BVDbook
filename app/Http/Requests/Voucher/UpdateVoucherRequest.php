<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:vouchers,sku,' . $this->route('voucher'),
            'discount_amount' => 'required|numeric|min:1000|max:99999999|lt:min_order_amount',
            'min_order_amount' => 'required|numeric|min:1000|max:99999999',
            'usage_limit' => 'required|integer|min:1|max:2000000000',
            'description' => 'required|string|max:255',
            'start' => 'required|date|after_or_equal:today',
            'end' => 'required|date|after_or_equal:start|after_or_equal:today'
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Tên Voucher bắt buộc nhập",
            "name.min" => "Tên voucher > 1 kí tự",
            "name.max" => "Tên voucher < 250 kí tự",
            "sku.required" => "Mã Voucher bắt buộc nhập",
            "sku.unique" => "Mã Voucher đã tồn tại. Vui lòng chọn mã khác.",
            "sku.min" => "Mã Voucher > 1 kí tự",
            "sku.max" => "Mã Voucher < 250 kí tự",
            "discount_amount.required" => "Số tiền giảm bắt buộc nhập",
            "discount_amount.numeric" => "Số tiền giảm phải là số",
            "discount_amount.min" => "Số tiền giảm phải lớn hơn 1000",
            "discount_amount.max" => "Số tiền giảm phải nhỏ hơn 99,000,000",
            'discount_amount.lt' => 'Số tiền giảm phải nhỏ hơn số tiền tối thiểu.',
            "min_order_amount.required" => "Số tiền tối thiểu bắt buộc nhập",
            "min_order_amount.numeric" => "Số tiền tối thiểu phải là số",
            "min_order_amount.min" => "Số tiền tối thiểu phải lớn hơn 1000",
            "min_order_amount.max" => "Số tiền tối thiểu phải nhỏ hơn 99,000,000",
            "usage_limit.required" => "Số lượt sử dụng bắt buộc nhập",
            "usage_limit.numberic" => "Số lượt sử dụng phải là số",
            "usage_limit.min" => "Số lượt sử dụng > 1 ",
            "usage_limit.max" => "Số lượt sử dụng < 2.000.000.000",
            "description.required" => "Mô tả bắt buộc nhập",
            "start.required" => "Ngày bắt đầu bắt buộc nhập",
            "end.required" => "Ngày kết thúc bắt buộc nhập",
            "start.after_or_equal" => "Ngày bắt đầu không được nhỏ hơn ngày hiện tại.",
            "end.after_or_equal" => "Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu và không được nhỏ hơn ngày hiện tại.",
        ];
    }

}

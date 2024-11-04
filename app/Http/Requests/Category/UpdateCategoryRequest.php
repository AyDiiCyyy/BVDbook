<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('id'); // Lấy ID của danh mục hiện tại
        $category = Category::findOrFail($categoryId);

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->whereNull('deleted_at')
                    ->ignore($categoryId), // Bỏ qua danh mục hiện tại
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    // Kiểm tra nếu parent_id là một trong các danh mục con của danh mục hiện tại
                    if ($value && $category->descendants()->pluck('id')->contains((int)$value)) {
                        $fail('Không thể chọn danh mục con làm danh mục cha.');
                    }
                },
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là một chuỗi ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug đã tồn tại và chưa bị xóa. Vui lòng chọn slug khác.',
            'parent_id.exists' => 'Danh mục cha không hợp lệ.',
            'image.image' => 'Ảnh phải là một tệp hình ảnh.',
            'image.mimes' => 'Ảnh chỉ chấp nhận các định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Dung lượng ảnh không được vượt quá 2MB.',
        ];
    }
}

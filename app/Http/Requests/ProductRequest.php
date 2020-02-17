<?php

namespace App\Http\Requests;

class ProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validator = [
            'name' => 'required|max:255|unique:products,name,' . $this->hidden_id,
            'avatar' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|digits_between:1,16',
            'category_id' => 'required|digits_between:1,10'
        ];

//
        return $validator;
    }

    public function messages()
    {
        return [
            'name.required' => '*Tên sản phẩm không được để trống.',
            'name.max' => '*Không được vượt quá 255 ký tự',
            'name.unique' => '*Tên sản phẩm đã tồn tại.',
            'avatar.mimes' => '*Chỉ chấp nhận ảnh JPG, JPEG, PNG',
            'avatar.max' => '*Yêu cầu ảnh không quá 2MB',
            'price.required' => '*Giá sản phẩm không được để trống.',
            'price.digits_between' => '*Giá phải là số và từ 1-16 ký tự',
            'category_id.required' => '*Danh mục không được để trống.',
            'category_id.digits_between' => '*Danh mục không hợp lệ',
        ];
    }
}

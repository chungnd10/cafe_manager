<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        // for add category
        $validator = [
            "name" => 'required|max:255'
        ];

        // for update category
        if ($this->hidden_id) {
            $validator['name'] = [
                'required',
                'max:255',
                Rule::unique('categories')->ignore($this->hidden_id)
            ];
        }
        return $validator;
    }

    public function messages()
    {
        return [
            "name.required" => "Tên không được để trống.",
            "name.unique" => "Tên đã tồn tại, hãy sử dụng tên khác.",
            "name.max" => "Không được vượt quá 255 ký tự."
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TableRequest extends FormRequest
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
        return [
            'name' => 'required|max:255|unique:tables,name,'.$this->hidden_id,
            'number_of_seats' => 'required|digits_between:1,10'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '*Tên bàn không được để trống.',
            'name.max' => '*Không được vượt quá 255 ký tự',
            'name.unique' => '*Tên bàn đã tồn tại.',
            'number_of_seats.required' => '*Số chỗ không được để trống.',
            'number_of_seats.digits_between' => '*Giá phải là số và từ 1-10 ký tự',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()]));
    }
}

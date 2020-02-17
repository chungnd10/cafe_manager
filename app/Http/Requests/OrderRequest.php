<?php

namespace App\Http\Requests;

class OrderRequest extends Request
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
            'products_id.*' => 'required|digits_between:1,10',
            'quantity.*' => 'required|digits_between:1,10',
        ];
    }

    public function messages()
    {
        return [
            'products_id.*.required' => "Bạn chưa chọn sản phẩm.",
            'quantity.*.required' => "Bạn chưa chọn số lượng.",
            'products_id.*.digits_between' => 'ID sản phẩm không đúng định dạng',
            'quantity.*.digits_between' => 'Số lượng phải là số và từ 1-10 ký tự',
        ];
    }

}

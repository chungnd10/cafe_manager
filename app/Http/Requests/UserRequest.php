<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'full_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'. $this->hidden_id,
            'phone_number' => 'required|digits_between:1,11|unique:users,phone_number,' . $this->hidden_id,
            'birthday' => 'required|date',
            'password' => 'required|min:8|max:40',
            'cf_password' => 'required|same:password',
            'avatar' => 'nullable|mimes:jpg,jpeg,png',
            'role_id' => 'required|numeric',
            'address' => 'required|max:255'
        ];
        if ($this->hidden_id) {
            $validator['password'] = 'nullable|min:8|max:40';
            $validator['cf_password'] = 'nullable|same:password';
        }

        return $validator;
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Họ tên không được để trống.',
            'full_name.max' => 'Không được vượt quá 255 ký tự',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email sai định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone_number.required' => 'Họ tên không được để trống.',
            'phone_number.digits_between' => 'Số điện thoại sai định dạng',
            'phone_number.unique' => 'Số điện thoại đã được sử dụng.',
            'birthday.required' => 'Ngày sinh không được để trống.',
            'birthday.date' => 'Ngày sinh sai định dạng',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu yêu cầu từ 8-40 ký tự',
            'password.max' => 'Mật khẩu yêu cầu từ 8-40 ký tự',
            'cf_password.required' => 'Nhập lại mật khẩu không được để trống.',
            'cf_password.same' => 'Nhập lại mật khẩu không đúng',
            'avatar.mimes' => 'Chỉ chấp nhận ảnh jpg, jpeg, png',
            'role_id.required' => 'Quyền không được để trống.',
            'address.required' => 'Địa chỉ không được để trống.',
            'address.max' => 'Không được vượt quá 255 ký tự'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()]));
    }
}

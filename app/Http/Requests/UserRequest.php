<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        if ($this->isMethod('PUT')) {

            $id = request()->id;
            $rules = [
                'name' => 'required|string|max:100|regex:/(^([a-zA-Z ]+)?$)/u',
                'email' => 'required|email|max:200|unique:users,email|email:rfc,dns'.$id,
                'contact_no' => 'required|unique:users,contact_no|max:20|regex:/[0-9]/',
            ];

            if (isset(request()->role_id)) {
                $rules['role_id'] = 'required|exists:roles,id';
            }

            if (isset(request()->password)) {
                $rules['password'] = 'required|string|min:8|confirmed|regex:/(^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$)/u';
            }

            return $rules;
        }

        $rules = ['name' => 'required|string|max:100|regex:/(^([a-zA-Z ]+)?$)/u'];

        if (isset(request()->type) && $this->isMethod('POST') && $this->url('/users')) {
            $rules['email'] = 'required|email|max:200|unique:users';
            $rules['password'] = 'required|string|min:8|confirmed|regex:/(^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$)/u';
            $rules['password_confirmation'] = 'required';
            $rules['contact_no'] = 'required|unique:users,contact_no|max:20|regex:/[0-9]/';
            $rules['role_id'] = 'required|exists:roles,id';
            $rules['code'] = 'required_if:role_id,==,2';

            return $rules;

        }


        if (isset(request()->password)) {
            $rules['password'] = 'required|string|min:8|confirmed|regex:/(^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$)/u';
            $rules['password_confirmation'] = 'required';
        }

        if (isset(request()->contact_no) && request()->contact_no !== auth()->user()->contact_no) {
            $rules['contact_no'] = 'required|unique:users,contact_no|max:20|regex:/[0-9]/';
        }

        if (isset(request()->email) && request()->email !== auth()->user()->email) {
            $rules['email'] = 'required|email|max:200|unique:users';
        }

        return $rules;

    }
}

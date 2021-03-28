<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                'name' => 'required|unique:roles,name,'.$id.'|string|max:100|regex:/(^([a-zA-Z ]+)?$)/u',
                'description' => 'required|string'
            ];

            return $rules;
        }

        return [
            'name' => 'required|unique:roles,name|string|max:100|regex:/(^([a-zA-Z ]+)?$)/u',
            'description' => 'required|string'
        ];
    }
}

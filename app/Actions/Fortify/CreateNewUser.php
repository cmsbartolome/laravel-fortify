<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100','regex:/(^([a-zA-Z ]+)?$)/u'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)
                //'email:rfc,dns',
            ],
            'contact_no' => 'required|unique:users,contact_no|max:20|regex:/[0-9]/',
            'password' => $this->passwordRules(),
        ])->validate();


        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'contact_no' => $input['contact_no'],
            'role_id' => 2,
            'password' => $input['password'],
        ]);

    }
}

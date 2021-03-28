<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'email' => $this->email,
//            'email_verified_at' => $this->email_verified_at,
//            'login_attempts' => $this->login_attempts,
            'status' => $this->status,
//            'password' => $this->password,
//            'two_factor_secret' => $this->two_factor_secret,
//            'two_factor_recovery_codes' => $this->two_factor_recovery_codes,
//            'created_by' => $this->created_by,
//            'parent_id' => $this->parent_id,
//            'contact_no' => $this->contact_no,
//            'remember_token' => $this->remember_token,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at
        ];
    }
}

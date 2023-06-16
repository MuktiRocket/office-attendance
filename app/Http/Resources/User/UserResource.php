<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use function PHPUnit\Framework\callback;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'designation' => [
                'name' => $this->user_designation->designation,
                'id' => $this->user_designation->id
            ],
            'company' => [
                'name' => $this->user_company->name ?? '',
                'id' => $this->user_company->id ?? ''
            ],
            'email' => $this->email,
            'active_status' => $this->active_status
        ];  ;
    }
}

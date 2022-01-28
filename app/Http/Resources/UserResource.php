<?php

namespace App\Http\Resources;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'type' => 'users',
            'attributes' => [
                'profile' => $this->profile,
                'name' => $this->name,
                'email' => $this->email,
                'created' => $this->created_at,
                'updated' => $this->updated_at,
            ]
        ];
    }
}

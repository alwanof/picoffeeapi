<?php

namespace App\Http\Resources;

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
            'type' => 'Users',
            'attributes' => [
                'profile_id' => $this->profile_id,
                'name' => $this->name,
                'email' => $this->email,
                'created' => $this->created_at,
                'updated' => $this->updated_at,
            ]
        ];
    }
}

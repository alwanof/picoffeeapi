<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //$userId = $this->user_id;
        //$user = new UserResource($userId);
        return [
            'id' => $this->id,
            'type' => 'Profiles',
            'attributes' => [
                'user' => $this->user,
                'url' => $this->url,
                'gender' => $this->gender,
            ]
        ];
    }
}

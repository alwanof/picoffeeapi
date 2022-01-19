<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
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
            'id' => (string)$this->id,
            'type' => 'Tweet',
            'attributes' => [
                'user_id' => $this->user_id,
                'tweet' => $this->tweet,
                'likes_count' => $this->likes_count,
                'created' => $this->created_at,
                'updated' => $this->updated_at,


            ]


        ];
    }
}

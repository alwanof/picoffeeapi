<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => 'Comments',
            'attributes' => [
                'tweet_id' => $this->tweet_id,
                'user_id' => $this->user_id,
                'body' => $this->body,
                'created' => $this->created_at,
                'updated' => $this->updated_at,

            ]


        ];
    }
}

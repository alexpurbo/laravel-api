<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class commentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'created_at' => date_format($this->created_at, 'Y-m-d H:m:s'),
            'comments_content' => $this->comments_content,
            'commentator' => $this->whenLoaded('commentator'),
            'commentOnPost' => $this->whenLoaded('commentOnPost')
        ];
    }
}

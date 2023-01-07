<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'title' => $this->title,
            'news_con' => $this->news_con,
            'author' => $this->author,
            'writer' => $this->whenLoaded('writer'),
            'created_at' => date_format($this->created_at, 'Y-m-d H:m:s')
        ];
    }
}

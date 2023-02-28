<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCommentResource extends JsonResource
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
            'article title' => $this->article->title,
            'user' => $this->user->name,
            'body' => $this->body,
            'created_at' => $this->created_at->format('l, d F Y'),
            'updated_at' => $this->updated_at->format('l, d F Y'),
        ];
    }
}

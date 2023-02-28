<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailArticleResource extends JsonResource
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
            'user_id' => $this->user,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'tag' => TagResource::collection($this->article_tags),
            'komentar' => ArticleCommentResource::collection($this->comments),
            'created_at' => $this->created_at->format('l, d F Y'),
        ];
    }
}

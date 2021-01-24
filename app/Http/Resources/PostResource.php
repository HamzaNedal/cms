<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->title,
            'slug'=>$this->slug,
            'description'=> $this->description,
            'status'=>$this->status(),
            'comment_able'=>$this->comment_able,
            'create_date'=>$this->created_at->format('d-m-Y h:i a'),
            'author'=> new UserResource($this->user),
            'category'=> new CategoryResource($this->category),
            'tags'=> TagResource::collection($this->tags),
            'media'=> MediaResource::collection($this->media),
            'comments'=> $this->comments->count(),
            'active_comments'=> $this->comments->where('status',1)->count(),

        ];
    }
}

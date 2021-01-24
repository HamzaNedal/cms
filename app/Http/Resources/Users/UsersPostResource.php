<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersPostResource extends JsonResource
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
            'post_id'=>$this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'description'=> $this->description,
            'status'=>$this->status,
            'status_text'=>$this->status(),
            'comment_able'=>$this->comment_able,
            'create_date'=>$this->created_at->format('d-m-Y h:i a'),
            'category'=> new UsersCategoryResource($this->category),
            'tags'=> UsersTagResource::collection($this->tags),
            'media'=> UsersMediaResource::collection($this->media),
            'comments_count'=> $this->comments->count(),
            'comments'=> UsersPostsCommentsResource::collection($this->comments),

   
        ];
    }
}

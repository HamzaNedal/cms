<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'name'=>$this->name,
            'email'=>$this->email,
            'website'=>$this->website,
            'comment'=>$this->comment,
            'status'=>$this->status(),
            'auther'=>$this->user_id !=null ? "Member" : "Guest",
            'create_date'=>$this->created_at->format('d-m-Y h:i a'),
            
        ];
    }
}

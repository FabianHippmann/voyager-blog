<?php

namespace Pvtl\VoyagerBlog\Http\Resources;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPost extends JsonResource
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
            'author' => optional($this->authorId)->firstname,
            'body' => $this->body,
            'created_at' => $this->created_at->format('d.m.Y'),
            'slug' => $this->slug,
            'image' => Voyager::image($this->image),
            'meta_description' => $this->meta_description,
            'title' => $this->title
        ];
    }
}

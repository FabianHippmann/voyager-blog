<?php

namespace Pvtl\VoyagerBlog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}

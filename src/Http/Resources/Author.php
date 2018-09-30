<?php

namespace Pvtl\VoyagerBlog\Http\Resources;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Resources\Json\JsonResource;

class Author extends JsonResource
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
            'avatar' => Voyager::image($this->avatar),
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
        ];
    }
}

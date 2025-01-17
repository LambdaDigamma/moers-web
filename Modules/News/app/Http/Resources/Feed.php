<?php

namespace Modules\News\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Feed extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    {
        return parent::toArray($request);
    }
}

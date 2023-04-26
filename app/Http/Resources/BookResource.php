<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'price' => $this->price,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'category_id' => $this->category_id,
            'tag_id' => $this->tag_id,
            'publisher_id' => $this->publisher_id,
            'translator_id' => $this->translator_id,
            'writer_id' => $this->writer_id,
        ];
    }
}

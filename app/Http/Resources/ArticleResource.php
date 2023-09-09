<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // parent::toArray($request)

        // QUEDE AQUI => CREAR LOS OTROS SERIALIZADORES - VER CHATGPT
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->multimedia_url,
            'except' => $this->except,
            'url' => $this->url,
            'publishedAt' => $this->published_at,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'source' => SourceResource::make($this->whenLoaded('source')),
        ];
    }
}

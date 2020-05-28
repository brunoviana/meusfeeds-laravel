<?php

namespace App\Http\Resources\Feed;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedResource extends JsonResource
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
            'id' => $this->id,
            'titulo' => $this->titulo,
            'dominio' => $this->dominio,
            'link_rss' => $this->link_rss,
            'nao_lidos' => $this->nao_lidos,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

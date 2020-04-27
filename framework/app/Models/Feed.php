<?php

namespace Framework\Models;

use Illuminate\Database\Eloquent\Model;

use Domain\Feed\Entities\Feed as FeedEntity;

use Framework\Adapters\Feed\Services\BuscadorDeArtigosService;

class Feed extends Model
{
    public function map(FeedEntity $feed)
    {
        $this->titulo = $feed->titulo();
        $this->link_rss = $feed->linkRss();

        return $this;
    }

    public function entity() : FeedEntity
    {
        $feed = new FeedEntity(
            $this->titulo,
            $this->link_rss,
            app(BuscadorDeArtigosService::class)
        );

        if ($this->id) {
            $feed->id($this->id);
        }

        return $feed;
    }
}

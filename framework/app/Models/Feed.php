<?php

namespace Framework\Models;

use Illuminate\Database\Eloquent\Model;

use Domain\Feed\Entities\Feed as FeedEntity;

use Framework\Models\Feed\Artigo;

class Feed extends Model
{
    public function artigos()
    {
        return $this->hasMany(Artigo::class);
    }

    public function map(FeedEntity $feed)
    {
        $this->titulo = $feed->titulo();
        $this->link_rss = $feed->linkRss();

        return $this;
    }

    public function entity() : FeedEntity
    {
        $feed = FeedEntity::novo(
            $this->titulo,
            $this->link_rss
        );

        if ($this->id) {
            $feed->id($this->id);
        }

        return $feed;
    }
}

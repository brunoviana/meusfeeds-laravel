<?php

namespace Framework\Models;

use Illuminate\Database\Eloquent\Model;

use Domain\Feed\Entities\Feed as FeedEntity;

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

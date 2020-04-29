<?php

namespace Feed\Tests\TestAdapters\Domain;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Interfaces\FeedRepositoryInterface;

class FeedRepositoryFake implements FeedRepositoryInterface
{
    private $feeds = [];

    public function salvar(Feed $feed) : void
    {
        $this->feeds[] = $feed;

        $feed->id(
            count($this->feeds)
        );
    }
}

<?php

namespace Tests\Feature\App\Feed\Adapters;

use App\Feed\Interfaces\FeedRepositoryInterface;

use Domain\Feed\Entities\Feed;

class TesteFeedRepository implements FeedRepositoryInterface
{
    protected $feeds = [];

    public function buscaFeedComLink(string $link)
    {
        foreach ($this->feeds as $feed) {
            if ($feed->linkRss() == $link) {
                return $feed;
            }
        }
    }

    public function save(Feed $feed)
    {
        $this->feeds[] = $feed;

        return true;
    }
}

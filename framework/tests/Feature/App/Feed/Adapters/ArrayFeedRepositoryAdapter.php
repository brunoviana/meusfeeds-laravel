<?php

namespace Tests\Feature\App\Feed\Adapters;

use App\Feed\Interfaces\Repositories\FeedRepositoryInterface;

use Domain\Feed\Entities\Feed;

class ArrayFeedRepositoryAdapter implements FeedRepositoryInterface
{
    protected $feeds = [];

    public function buscarPeloLink(string $link)
    {
        foreach ($this->feeds as $feed) {
            if ($feed->linkRss() == $link) {
                return $feed;
            }
        }
    }

    public function save(Feed $feed) : int
    {
        $this->feeds[] = $feed;

        return count($this->feeds);
    }
}

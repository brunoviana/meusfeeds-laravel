<?php

namespace Tests\Feature\App\Feed\Adapters;

use App\Feed\Interfaces\FeedRepositoryInterface;
use App\Feed\Responses\CriarNovoFeedResponse;

use Domain\Feed\Entities\Feed;

class TesteFeedRepository implements FeedRepositoryInterface
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

    public function save(Feed $feed) : CriarNovoFeedResponse
    {
        $this->feeds[] = $feed;

        $feed->id(count($this->feeds));

        return new CriarNovoFeedResponse($feed);
    }
}

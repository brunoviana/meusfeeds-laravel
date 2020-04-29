<?php

namespace App\Feed\Responses;

use Domain\Feed\Entities\Feed;

class CriarNovoFeedResponse
{
    private Feed $feed;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    public function feed()
    {
        return $this->feed;
    }
}

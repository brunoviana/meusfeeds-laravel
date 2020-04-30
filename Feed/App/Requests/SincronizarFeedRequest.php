<?php

namespace Feed\App\Requests;

use Feed\Domain\Entities\Feed;

class SincronizarFeedRequest
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

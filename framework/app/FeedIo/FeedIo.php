<?php

namespace Framework\FeedIo;

use FeedIo\FeedIo as FeedIoParent;

class FeedIo extends FeedIoParent
{
    public function discover(string $url) : array
    {
        $explorer = new Explorer($this->client, $this->logger);

        return $explorer->discover($url);
    }
}

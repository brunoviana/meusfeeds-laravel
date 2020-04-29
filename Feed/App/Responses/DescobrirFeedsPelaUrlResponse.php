<?php

namespace Feed\App\Responses;

class DescobrirFeedsPelaUrlResponse
{
    private array $feeds;

    public function __construct(array $feeds)
    {
        $this->feeds = $feeds;
    }

    public function feeds()
    {
        return $this->feeds;
    }
}

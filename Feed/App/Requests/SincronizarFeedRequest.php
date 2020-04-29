<?php

namespace Feed\App\Requests;

class SincronizarFeedRequest
{
    private int $feedId;

    public function __construct(int $feedId)
    {
        $this->feedId = $feedId;
    }

    public function feedId()
    {
        return $this->feedId;
    }
}

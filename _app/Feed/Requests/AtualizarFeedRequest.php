<?php

namespace App\Feed\Requests;

class AtualizarFeedRequest
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

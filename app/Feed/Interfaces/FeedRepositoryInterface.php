<?php

namespace App\Feed\Interfaces;

use App\Feed\Responses\CriarNovoFeedResponse;

use Domain\Feed\Entities\Feed;

interface FeedRepositoryInterface
{
    public function buscarPeloLink(string $link);

    public function save(Feed $feed) : CriarNovoFeedResponse;
}

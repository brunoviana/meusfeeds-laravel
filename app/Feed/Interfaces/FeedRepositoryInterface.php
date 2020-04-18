<?php

namespace App\Feed\Interfaces;

use Domain\Feed\Entities\Feed;

interface FeedRepositoryInterface
{
    public function buscaFeedComLink(string $link);

    public function save(Feed $feed);
}

<?php

namespace App\Feed\Interfaces\Repositories;

use Domain\Feed\Entities\Feed;

interface FeedRepositoryInterface
{
    public function buscarPeloLink(string $link);

    public function save(Feed $feed) : int;
}

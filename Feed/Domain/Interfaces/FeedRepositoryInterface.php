<?php

namespace Feed\Domain\Interfaces;

use Feed\Domain\Entities\Feed;

interface FeedRepositoryInterface
{
    public function buscarPeloLink(string $link);
    
    public function salvar(Feed $feed) : void;
}

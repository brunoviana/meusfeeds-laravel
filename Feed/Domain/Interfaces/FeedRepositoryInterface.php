<?php

namespace Feed\Domain\Interfaces;

use Feed\Domain\Entities\Feed;

interface FeedRepositoryInterface
{
    public function buscar(int $id);
    
    public function buscarPeloLink(string $link);
    
    public function salvar(Feed $feed) : void;
}

<?php

namespace Domain\Feed\Interfaces\Repositories;

use Domain\Feed\Entities\Feed;

interface FeedRepositoryInterface
{
    /**
     * @throes FeedNaoEncontradoException se feed não existe
     */
    public function buscar($id) : Feed;

    public function buscarPeloLink(string $link);

    public function save(Feed $feed) : int;
}

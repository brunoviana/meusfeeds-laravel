<?php

namespace Domain\Feed\Interfaces\Repositories;

use Domain\Feed\Entities\Feed;

interface FeedRepositoryInterface
{
    /**
     * @throes FeedNaoEncontradoException se feed não existe
     */
    public function buscar(int $id) : Feed;

    /**
     * @throes FeedNaoEncontradoException se feed não existe
     */
    public function buscarPeloLink(string $link) : Feed;

    /**
     * @returns int Id do feed no banco
     */
    public function save(Feed $feed) : int;
}

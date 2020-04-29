<?php

namespace Domain\Feed\Interfaces\Repositories;

use Domain\Feed\Entities\Feed;
use Domain\Feed\ValueObjects\Data;

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

    /**
     * Retorna data da última vez que os artigos do
     * feed foram atualizados.
     */
    public function dataDaUltimaAtualizacao(Feed $feed) : Data;
}

<?php

namespace Framework\Services;

use FeedIo\FeedIo;
use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;
use Feed\Domain\ValueObjects\Data;
use Feed\Domain\ValueObjects\Autor;

use Framework\Models\Artigo as ArtigoModel;

use Feed\Domain\Interfaces\BuscadorDeArtigosInterface;

class BuscadorDeArtigos implements BuscadorDeArtigosInterface
{
    private $feedIo;

    public function __construct(FeedIo $feedIo)
    {
        $this->feedIo = $feedIo;
    }

    public function buscarTodos(Feed $feed) : array
    {
        $result = $this->feedIo->read(
            $feed->linkRss()
        );

        $artigosEncontrados = [];

        foreach ($result->getFeed() as $item) {
            $autor = $item->getAuthor() ? (string) $item->getAuthor()->getName() : '';
            $descricao = $this->limpaDescricao($item->getDescription());

            $artigosEncontrados[] = Artigo::novo(
                $item->getTitle(),
                $descricao,
                $item->getLink(),
                new Autor($autor),
                new Data(
                    $item->getLastModified()->format('Y'),
                    $item->getLastModified()->format('m'),
                    $item->getLastModified()->format('d'),
                ),
                $feed->id(),
                Artigo::NAO_LIDO
            );
        }

        return $artigosEncontrados;
    }

    public function buscarNovos(Feed $feed) : array
    {
        $ultimoArtigo = ArtigoModel::orderBy('created_at', 'DESC')
                                    ->get()
                                    ->first();

        if (!$ultimoArtigo) {
            return $this->buscarTodos($feed);
        }

        $result = $this->feedIo->readSince(
            $feed->linkRss(),
            new \DateTime(
                $ultimoArtigo->created_at->subDay()->format('Y-m-d')
            )
        );

        $artigosEncontrados = [];

        foreach ($result->getFeed() as $item) {
            $artigo = ArtigoModel::where('link', $item->getLink())
                                    ->where('feed_id', $feed->id())
                                    ->get()
                                    ->first();

            if ($artigo) {
                continue;
            }

            $autor = $item->getAuthor() ? (string) $item->getAuthor()->getName() : '';
            $descricao = $this->limpaDescricao($item->getDescription());

            $artigosEncontrados[] = Artigo::novo(
                $item->getTitle(),
                $descricao,
                $item->getLink(),
                new Autor($autor),
                new Data(
                    $item->getLastModified()->format('Y'),
                    $item->getLastModified()->format('m'),
                    $item->getLastModified()->format('d'),
                ),
                $feed->id(),
                Artigo::NAO_LIDO
            );
        }

        return $artigosEncontrados;
    }

    protected function limpaDescricao($descricao)
    {
        if (!$descricao) {
            return '';
        }

        $semHtml = strip_tags($descricao);

        preg_match('#.*[\.\?!]#', $semHtml, $limitado);

        if (isset($limitado[0])) {
            return trim($limitado[0]);
        }

        return trim($semHtml);
    }
}

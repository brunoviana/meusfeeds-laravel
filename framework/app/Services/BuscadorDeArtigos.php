<?php

namespace Framework\Services;

use Feed\Domain\Entities\Feed;
use Feed\Domain\Entities\Artigo;
use Feed\Domain\ValueObjects\Autor;
use Feed\Domain\ValueObjects\Data;
use Feed\Domain\Interfaces\BuscadorDeArtigosInterface;

use Framework\Models\Artigo as ArtigoModel;

use FeedIo\FeedIo;

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

            $artigosEncontrados[] = Artigo::novo(
                $item->getTitle(),
                $item->getDescription(),
                $item->getLink(),
                new Autor($autor),
                new Data(
                    $item->getLastModified()->format('Y'),
                    $item->getLastModified()->format('m'),
                    $item->getLastModified()->format('d'),
                )
            );
        }

        return $artigosEncontrados;
    }

    public function buscarNovos(Feed $feed) : array
    {
        $ultimoArtigo = ArtigoModel::orderBy('created_at', 'DESC')
                                    ->get()
                                    ->first();

        if(!$ultimoArtigo){
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
            $autor = $item->getAuthor() ? (string) $item->getAuthor()->getName() : '';

            $artigosEncontrados[] = Artigo::novo(
                $item->getTitle(),
                $item->getDescription(),
                $item->getLink(),
                new Autor($autor),
                new Data(
                    $item->getLastModified()->format('Y'),
                    $item->getLastModified()->format('m'),
                    $item->getLastModified()->format('d'),
                )
            );
        }

        return $artigosEncontrados;
    }

    // public function buscar(string $link, string $aPartirDe = '') : array
    // {
    //     if (!empty($aPartirDe)) {
    //         $result = $this->feedIo->readSince($link, (new \DateTime($aPartirDe))->modify('-1 day'));
    //     } else {
    //         $result = $this->feedIo->read($link);
    //     }

    //     $artigosEncontrados = [];

    //     foreach ($result->getFeed() as $item) {
    //         $artigosEncontrados[] = [
    //             'titulo' => $item->getTitle(),
    //             'descricao' => $item->getDescription(),
    //             'link' => $item->getLink(),
    //             'autor' => $item->getAuthor() ? (string) $item->getAuthor()->getName() : '',
    //             'data_publicacao' => $item->getLastModified()->format('Y-m-d'),
    //         ];
    //     }

    //     return $artigosEncontrados;
    // }
}

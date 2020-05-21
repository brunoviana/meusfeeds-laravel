<?php

namespace Feed\Domain\Services;

use Feed\Domain\Interfaces\ExtratorDeFeedsInterface;
use Feed\Domain\Repositories\FeedRepositoryInterface;
use Feed\Domain\Interfaces\BuscadorDeArtigosInterface;
use Feed\Domain\Repositories\ArtigoRepositoryInterface;

class Service
{
    private $extratorDeFeeds;

    private $feedRepository;

    private $buscadorDeArtigos;

    private $artigoRepository;

    public function setExtratorDeFeeds(ExtratorDeFeedsInterface $extratorDeFeeds)
    {
        $this->extratorDeFeeds = $extratorDeFeeds;
    }

    public function getExtratorDeFeeds() : ExtratorDeFeedsInterface
    {
        if (!$this->extratorDeFeeds) {
            throw new \RuntimeException('Extrator de Feed não foi setado.');
        }

        return $this->extratorDeFeeds;
    }

    public function setFeedRepository(FeedRepositoryInterface $feedRepository)
    {
        $this->feedRepository = $feedRepository;
    }

    public function getFeedRepository() : FeedRepositoryInterface
    {
        if (!$this->feedRepository) {
            throw new \RuntimeException('Repositório de Feed não foi setado.');
        }

        return $this->feedRepository;
    }

    public function setArtigoRepository(ArtigoRepositoryInterface $artigoRepository)
    {
        $this->artigoRepository = $artigoRepository;
    }

    public function getArtigoRepository() : ArtigoRepositoryInterface
    {
        if (!$this->artigoRepository) {
            throw new \RuntimeException('Repositório de Feed não foi setado.');
        }

        return $this->artigoRepository;
    }

    public function setBuscadorDeArtigos(BuscadorDeArtigosInterface $buscadorDeArtigos)
    {
        $this->buscadorDeArtigos = $buscadorDeArtigos;
    }

    public function getBuscadorDeArtigos() : BuscadorDeArtigosInterface
    {
        if (!$this->buscadorDeArtigos) {
            throw new \RuntimeException('Buscador de Artigos não foi setado.');
        }

        return $this->buscadorDeArtigos;
    }
}

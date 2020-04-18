<?php

namespace Domain\Feed\Entities;

class Feed
{
    private $titulo;

    private $linkRss;

    public function __construct(string $titulo, string $linkRss)
    {
        $this->titulo = $titulo;
        $this->linkRss = $linkRss;
    }

    public function titulo()
    {
        return $this->titulo;
    }

    public function linkRSS()
    {
        return $this->linkRss;
    }
}

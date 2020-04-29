<?php

namespace Feed\App\Requests;

class CriarNovoFeedRequest
{
    private string $titulo;

    private string $linkRss;

    public function __construct(string $titulo, $linkRss)
    {
        $this->titulo = $titulo;
        $this->linkRss = $linkRss;
    }

    public function titulo()
    {
        return $this->titulo;
    }

    public function linkRss()
    {
        return $this->linkRss;
    }
}

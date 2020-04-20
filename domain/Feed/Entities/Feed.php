<?php

namespace Domain\Feed\Entities;

class Feed
{
    private $id;

    private $titulo;

    private $linkRss;

    public function __construct(string $titulo, string $linkRss)
    {
        $this->titulo = $titulo;
        $this->linkRss = $linkRss;
    }

    public function id($id=null)
    {
        if (is_int($id)) {
            $this->id = $id;
        }
        
        return $id;
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

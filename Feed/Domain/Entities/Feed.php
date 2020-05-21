<?php

namespace Feed\Domain\Entities;

class Feed
{
    private int $id = 0;

    private string $titulo;

    private string $linkRss;

    public static function novo(string $titulo, string $linkRss) : Feed
    {
        return new self($titulo, $linkRss);
    }

    private function __construct(string $titulo, string $linkRss)
    {
        $this->titulo = $titulo;
        $this->linkRss = $linkRss;
    }

    public function id($id = null)
    {
        if (is_int($id)) {
            if ($this->id > 0) {
                throw new \RuntimeException('Id do feed já foi definido.');
            }

            $this->id = $id;
        }

        return $this->id;
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

<?php

namespace Feed\Domain\Entities;

class Artigo
{
    private int $id = 0;

    public static function novo() : Artigo
    {
        return new self();
    }

    private function __construct()
    {
    }

    public function id($id=null)
    {
        if (is_int($id)) {
            if ($this->id > 0) {
                throw new \RuntimeException('Id do artigo já foi definido.');
            }

            $this->id = $id;
        }
        
        return $this->id;
    }
}

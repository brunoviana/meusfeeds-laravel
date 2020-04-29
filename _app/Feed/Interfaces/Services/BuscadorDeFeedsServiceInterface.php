<?php

namespace App\Feed\Interfaces\Services;

interface BuscadorDeFeedsServiceInterface
{
    public function buscar(string $url) : array;
}

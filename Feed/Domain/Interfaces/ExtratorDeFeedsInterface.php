<?php

namespace Feed\Domain\Interfaces;

interface ExtratorDeFeedsInterface
{
    public function extrair(string $url) : array;
}

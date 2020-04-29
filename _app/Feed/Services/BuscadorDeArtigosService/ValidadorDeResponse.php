<?php

namespace App\Feed\Services\BuscadorDeArtigosService;

use App\Feed\Exceptions\ResponseInvalidoException;

class ValidadorDeResponse
{
    private array $chavesEsperadas = [
        'titulo',
        'descricao',
        'link',
        'autor',
        'data_publicacao',
    ];

    public function validar($response)
    {
        if (!is_array($response)) {
            throw new ResponseInvalidoException('Response deve ser um array');
        }

        foreach ($response as $artigo) {
            foreach ($this->chavesEsperadas as $chaveEsperada) {
                if (!in_array($chaveEsperada, array_keys($artigo))) {
                    throw new ResponseInvalidoException('Um atributo esperado não foi encontrado: '.$chaveEsperada);
                }
            }
        }
    }
}

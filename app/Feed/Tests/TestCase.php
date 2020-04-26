<?php

/**
 * IMPORTANTE!
 *
 * Como testes dependem diretamente do framework que os roda,
 * criei essa classe para tentar diminuir ao máximo possível a dependencia dos mesmos.
 *
 * Isso significa que aqui ficará concentrado tudo que os testes precisam usar
 * que depende do framework, assim se um dia mudarmos de framework, o impacto das mudanças
 * será minimizado.
 *
 * Atualmente dependemos do BaseTestCase do Laravel que implementa PHPUnit + Mockery;
 *
 * Observação: Como os métodos do próprio PHPUnit são padronizados em todo framework e em qualquer
 * linguagem (ex. assertEquals(), assertCount(), etc) eu vou ignorá-los.
 */

namespace App\Feed\Tests;

use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Esse método é responsavel por retornar a instancia da classe com
     * todas as suas dependencias e mocks injetados.
     */
    public function getInstance($class)
    {
        return app($class);
    }

    /**
     * Esse método é responsável por criar o mock utilizando o framework atual
     * e injetá-lo em uma função anonima que terá os seus assertions.
     */
    public function makeMock($class, $assetions)
    {
        return $this->mock($class, $assetions);
    }
}

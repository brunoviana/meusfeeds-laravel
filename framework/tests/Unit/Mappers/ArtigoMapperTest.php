<?php

namespace Tests\Unit\Mappers;

use Tests\TestCase;
use Feed\Domain\Entities\Artigo;
use Feed\Domain\ValueObjects\Data;

use Feed\Domain\ValueObjects\Autor;
use Framework\Mappers\ArtigoMapper;

use Framework\Models\Artigo as ArtigoModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtigoMapperTest extends TestCase
{
    use RefreshDatabase;

    public function test_Deve_Mapear_Entidade_Com_Sucesso()
    {
        $artigo = Artigo::novo(
            'Hello World',
            'Meu primeiro artigo',
            'https://brunoviana.net/hello-world',
            new Autor('Bruno Viana'),
            new Data(2020, 01, 01),
            1,
            Artigo::LIDO
        );

        $artigoModel = ArtigoMapper::criaModel($artigo);

        $this->assertEquals('Hello World', $artigoModel->titulo);
        $this->assertEquals('Meu primeiro artigo', $artigoModel->descricao);
        $this->assertEquals('https://brunoviana.net/hello-world', $artigoModel->link);
        $this->assertEquals('Bruno Viana', $artigoModel->autor);
        $this->assertEquals('2020-01-01', $artigoModel->data_publicacao->format('Y-m-d'));
        $this->assertEquals(1, $artigoModel->feed_id);
        $this->assertEquals(1, $artigoModel->lido);
    }

    public function test_Deve_Retornar_Entitade_Corretamente()
    {
        $artigoModel = new ArtigoModel();
        $artigoModel->titulo = 'Hello World';
        $artigoModel->descricao = 'Meu primeiro artigo';
        $artigoModel->link = 'https://brunoviana.net/hello-world';
        $artigoModel->autor = 'Bruno Viana';
        $artigoModel->data_publicacao = '2020-01-01';
        $artigoModel->feed_id = 1;
        $artigoModel->lido = 1;

        $artigo = ArtigoMapper::criaEntidade($artigoModel);

        $this->assertEquals('Hello World', $artigo->titulo());
        $this->assertEquals('Meu primeiro artigo', $artigo->descricao());
        $this->assertEquals('https://brunoviana.net/hello-world', $artigo->link());
        $this->assertEquals('Bruno Viana', $artigo->autor()->nome());
        $this->assertEquals('2020-01-01', $artigo->dataPublicacao()->formatoPadrao());
        $this->assertEquals(1, $artigo->feedId());
        $this->assertEquals(1, $artigo->lido());
    }
}

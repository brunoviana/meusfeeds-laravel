<?php

namespace App\Feed\Services;

use Domain\Feed\ValueObjects\ArtigoList;
use Domain\Feed\ValueObjects\Data;
use Domain\Feed\ValueObjects\Autor;
use Domain\Feed\Entities\Feed;

use App\Feed\Interfaces\Adapters\BuscadorDeArtigosAdapterInterface;
use App\Feed\Services\BuscadorDeArtigosService\ValidadorDeResponse;

class BuscadorDeArtigosService
{
    protected $buscadorAdapter;
    
    protected $validadorDeResponse;

    public function __construct(BuscadorDeArtigosAdapterInterface $buscadorAdapter)
    {
        $this->buscadorAdapter = $buscadorAdapter;
        $this->validadorDeResponse = new ValidadorDeResponse;
    }

    public function buscarAPartirDe(string $link, Data $aPartirDe) : ArtigoList
    {
        $artigosEncontrados = $this->buscadorAdapter->buscar(
            $link,
            $aPartirDe->vazio() ? '' : $aPartirDe->formatoPadrao()
        );

        $this->validadorDeResponse->validar($artigosEncontrados);

        $artigoList = new ArtigoList();

        foreach ($artigosEncontrados as $artigo) {
            $d = explode('-', $artigo['data_publicacao']);

            $artigoList->adicionar(
                $artigo['titulo'],
                $this->limparELimitarDescricao($artigo['descricao']),
                $artigo['link'],
                new Autor($artigo['autor']),
                new Data($d[0], $d[1], $d[2])
            );

            break;
        }

        return $artigoList;
    }

    public function limparELimitarDescricao($descricao)
    {
        if (!$descricao) {
            return '';
        }
        
        $semHtml = strip_tags($descricao);
        
        preg_match('#.*[\.\?!]#', $semHtml, $limitado);

        if (isset($limitado[0])) {
            return trim($limitado[0]);
        }

        return substr(trim($semHtml), 0, 200);
    }

    public function buscarEAtualizar(Feed $feed)
    {
        $artigos = $this->buscarAPartirDe(
            $feed->linkRss(),
            $feed->ultimaAtualizacao(),
        );

        foreach ($artigos as $artigo) {
            $feed->adicionarArtigo(
                $artigo->titulo(),
                $artigo->descricao(),
                $artigo->link(),
                $artigo->autor(),
                $artigo->dataPublicacao(),
                $artigo->lido(),
            );
        }

        $feed->ultimaAtualizacao(
            Data::agora()
        );
    }
}

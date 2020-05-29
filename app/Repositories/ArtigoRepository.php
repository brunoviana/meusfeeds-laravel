<?php

namespace App\Repositories;

use MeusFeeds\Feeds\Domain\Entities\Artigo;
use App\Mappers\ArtigoMapper;

use App\Models\Artigo as ArtigoModel;
use MeusFeeds\Feeds\Domain\Repositories\ArtigoRepositoryInterface;

class ArtigoRepository implements ArtigoRepositoryInterface
{
    public function buscarPeloId(int $id) : ?Artigo
    {
        $artigoModel = ArtigoModel::find($id);

        if ($artigoModel) {
            return ArtigoMapper::criaEntidade($artigoModel);
        }
    }

    public function todos() : array
    {
        $artigos = [];

        foreach (ArtigoModel::all() as $artigoModel) {
            $artigos[] = ArtigoMapper::criaEntidade($artigoModel);
        }

        return $artigos;
    }

    public function salvar(Artigo $artigo) : void
    {
        $artigoModel = ArtigoMapper::criaModel($artigo);

        $artigoModel->save();

        if (!$artigo->id()) {
            $artigo->id(
                $artigoModel->id
            );
        }
    }

    public function salvarVarios(array $artigos) : void
    {
        foreach ($artigos as $artigo) {
            $this->salvar($artigo);
        }
    }
}

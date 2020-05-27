<?php

namespace App\Models;

use App\Models\Convite;
use MeusFeeds\Usuarios\Domain\Interfaces\ListaDeConvitesInterface;

class ListaDeConvites implements ListaDeConvitesInterface
{
    public function emailExisteNaLista(string $email) : bool
    {
        $convite = Convite::where('email', $email)->first();

        return $convite != null;
    }
}

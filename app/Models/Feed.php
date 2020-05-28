<?php

namespace App\Models;

use App\Models\Artigo;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public function artigos()
    {
        return $this->hasMany(Artigo::class);
    }

    public function getNaoLidosAttribute()
    {
        return $this->artigos()->where('lido', 0)->count();
    }

    public function getDominioAttribute()
    {
        $parseUrl = parse_url(trim($this->link_rss));
        $explode =  explode('/', $parseUrl['path'], 2);

        return trim(
            $parseUrl['host'] ?? array_shift($explode)
        );
    }
}

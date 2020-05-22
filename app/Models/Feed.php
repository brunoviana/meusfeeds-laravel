<?php

namespace App\Models;

use App\Models\MeusFeeds\Feeds\Artigo;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public function artigos()
    {
        return $this->hasMany(Artigo::class);
    }
}

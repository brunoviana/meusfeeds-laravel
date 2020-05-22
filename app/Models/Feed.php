<?php

namespace Framework\Models;

use Framework\Models\Feed\Artigo;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public function artigos()
    {
        return $this->hasMany(Artigo::class);
    }
}

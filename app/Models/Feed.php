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
}

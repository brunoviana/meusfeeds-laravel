<?php

namespace Framework\Models;

use Illuminate\Database\Eloquent\Model;

use Domain\Feed\Entities\Feed as FeedEntity;

use Framework\Models\Feed\Artigo;

class Feed extends Model
{
    public function artigos()
    {
        return $this->hasMany(Artigo::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Regulamentos extends Model
{
    protected $table = 'tsilva.regulamentos';
    protected $fillable = ['titulo', 'resumo', 'obs', 'numeroregistro'];

    protected static function booted(){
        self::addGlobalScope('ordered', function (Builder $queryBuilder){
            $queryBuilder->orderBy('id', 'asc');
        });
    }
}

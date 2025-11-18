<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $table = 'tsilva.categorias';
    protected $fillable = ['nome'];
    public $timestamps = false;

    protected static function booted(){
        self::addGlobalScope('ordered', function (Builder $queryBuilder){
            $queryBuilder->orderBy('id', 'asc');
        });
    }
}

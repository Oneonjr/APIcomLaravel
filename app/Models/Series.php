<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'cover'];

    public function seasons()
    {
        return $this->hasMany(Season::class, 'series_id');
    }

    public function episodes() //criada para visualizar os episodios.
    {
        return $this->hasManyThrough(Episode::class, Season::class); 
        //hasManyThorugh -> ele faz com que todos acesse todos os episodios da serie atraves da temporadada da serie.
    }

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('nome');
        });
    }
}

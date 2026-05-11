<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $table = 'director';
    protected $primaryKey = 'id_director';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'biografia',
        'foto',
    ];

    public function peliculas()
    {
        return $this->hasMany(Pelicula::class, 'id_director');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'actor';
    protected $primaryKey = 'id_actor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'biografia',
        'foto',
    ];

    public function peliculas()
    {
        return $this->belongsToMany(
            Pelicula::class,
            'reparto',
            'id_actor',
            'id_pelicula'
        )->withPivot('papel');
    }
}

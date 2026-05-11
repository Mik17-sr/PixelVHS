<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    protected $table = 'pelicula';
    protected $primaryKey = 'id_pelicula';
    public $timestamps = true;

    protected $fillable = [
        'titulo',
        'resumen',
        'anio_lanzamiento',
        'precio_alquiler',
        'foto_caratula',
        'foto_portada',
        'banner',
        'id_director',
        'id_genero',
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class);
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function cintas()
    {
        return $this->hasMany(Cinta::class, 'id_pelicula');
    }

    public function actores()
    {
        return $this->belongsToMany(
            Actor::class,
            'reparto',
            'id_pelicula',
            'id_actor'
        )->withPivot('papel');
    }

    public function listaEspera()
    {
        return $this->hasMany(ListaEspera::class, 'id_pelicula');
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'id_pelicula');
    }
}

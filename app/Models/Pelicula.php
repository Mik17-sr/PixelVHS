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
        'duracion_minutos',
        'estudio',
        'precio_alquiler',
        'foto_portada',
        'banner',
        'clasificacion',
        'id_director',
        'id_genero',
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'id_genero', 'id_genero');
    }

    public function director()
    {
        return $this->belongsTo(Director::class, 'id_director', 'id_director');
    }

    public function cintas()
    {
        return $this->hasMany(Cinta::class, 'id_pelicula', 'id_pelicula');
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

    public function portadas()
    {
        return $this->hasMany(PortadaPelicula::class, 'id_pelicula');
    }
}

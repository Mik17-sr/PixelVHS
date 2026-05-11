<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $table = 'socio';
    protected $primaryKey = 'id_socio';
    public $timestamps = false;

    protected $fillable = [
        'id_socio',
        'max_peliculas_simultaneas',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_socio');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_socio');
    }

    public function listaEspera()
    {
        return $this->hasMany(ListaEspera::class, 'id_socio');
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'id_socio');
    }

    public function directoresFavoritos()
    {
        return $this->belongsToMany(
            Director::class,
            'gusta_director',
            'id_socio',
            'id_director'
        );
    }

    public function actoresFavoritos()
    {
        return $this->belongsToMany(
            Actor::class,
            'gusta_actor',
            'id_socio',
            'id_actor'
        );
    }

    public function generosFavoritos()
    {
        return $this->belongsToMany(
            Genero::class,
            'gusta_genero',
            'id_socio',
            'id_genero'
        );
    }
}

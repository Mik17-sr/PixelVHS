<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoracion';
    protected $primaryKey = 'id_valoracion';  
     public $timestamps = true;

    protected $fillable = [
        'id_pelicula',
        'id_socio',
        'puntuacion',
        'comentario',
        'fecha',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortadaPelicula extends Model
{
    protected $table = 'portada_pelicula';

    protected $primaryKey = 'id_portada';

    public $timestamps = false;

    protected $fillable = [
        'id_pelicula',
        'id_formato',
        'imagen'
    ];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula');
    }

    public function formato()
    {
        return $this->belongsTo(Formato::class, 'id_formato');
    }
}
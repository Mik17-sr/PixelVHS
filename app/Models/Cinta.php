<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cinta extends Model
{
    protected $table = 'cinta';
    protected $primaryKey = 'id_cinta';
    public $timestamps = true;


    protected $fillable = [
        'id_pelicula',
        'id_formato',
        'estado',
    ];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula');
    }

    public function formato()
    {
        return $this->belongsTo(Formato::class, 'id_formato');
    }

    public function prestamos()
    {
        return $this->belongsToMany(
            Prestamo::class,
            'cinta_prestamo',
            'id_cinta',
            'id_prestamo'
        );
    }
}

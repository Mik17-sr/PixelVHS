<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaEspera extends Model
{
    protected $table = 'lista_espera';
    protected $primaryKey = 'id_lista_espera';
    public $timestamps = true;

    protected $fillable = [
        'id_socio',
        'id_pelicula',
        'id_formato',
        'fecha_solicitud',
        'notificado'
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula');
    }

    public function formato()
    {
        return $this->belongsTo(Formato::class, 'id_formato');
    }
}

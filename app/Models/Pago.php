<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';
    protected $primaryKey = 'id_pago';
    public $timestamps = true;

    protected $fillable = [
        'tipo',
        'monto',
        'fecha_pago',
        'metodo_pago',
    ];

     public function multas()
    {
        return $this->belongsToMany(
            Multa::class,
            'pago_multa',
            'id_pago',
            'id_multa'
        );
    }

    public function prestamos()
    {
        return $this->belongsToMany(
            Prestamo::class,
            'pago_prestamo',
            'id_pago',
            'id_prestamo'
        );
    }
}

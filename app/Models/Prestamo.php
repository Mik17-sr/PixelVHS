<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'prestamo';
    protected $primaryKey = 'id_prestamo';
    public $timestamps = true;

    protected $fillable = [
        'id_socio',
        'fecha_inicio',
        'fecha_limite',
        'fecha_devolucion',
        'estado',
        'cargo_diario',
        'observaciones',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function cintas()
    {
        return $this->belongsToMany(
            Cinta::class,
            'cinta_prestamo',
            'id_prestamo',
            'id_cinta'
        );
    }

    public function multas()
    {
        return $this->hasMany(Multa::class, 'id_prestamo');
    }

    public function pagos()
    {
        return $this->belongsToMany(
            Pago::class,
            'pago_prestamo',
            'id_prestamo',
            'id_pago'
        );
    }
}

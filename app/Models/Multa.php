<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    protected $table = 'multa';
    protected $primaryKey = 'id_multa'; 
    public $timestamps = true;
    
    protected $fillable = [
        'id_prestamo',
        'id_tipo_multa',
        'valor',
        'fecha_generacion',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'id_prestamo');
    }

    public function tipoMulta()
    {
        return $this->belongsTo(TipoMulta::class, 'id_tipo_multa');
    }

    public function pagos()
    {
        return $this->belongsToMany(
            Pago::class,
            'pago_multa',
            'id_multa',
            'id_pago'
        );
    }
}

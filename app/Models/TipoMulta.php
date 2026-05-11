<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMulta extends Model
{
    protected $table = 'tipo_multa';
    protected $primaryKey = 'id_tipo_multa';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'concepto',
        'multiplicador',
    ];
}

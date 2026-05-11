<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    protected $table = 'formato';
    protected $primaryKey = 'id_formato';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'multiplicador',
    ];

    public function cintas()
    {
        return $this->hasMany(Cinta::class, 'id_formato');
    }

    public function listaEspera()
    {
        return $this->hasMany(ListaEspera::class, 'id_formato');
    }
}

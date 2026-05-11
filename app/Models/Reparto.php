<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reparto extends Model
{
    protected $table = 'reparto';
    protected $primaryKey = 'id_reparto';
    public $timestamps = false;

    protected $fillable = [
        'id_actor',
        'id_pelicula',
        'papel',
    ];

    public function actor()
    {
        return $this->belongsTo(Actor::class, 'id_actor');
    }

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula');
    }
}

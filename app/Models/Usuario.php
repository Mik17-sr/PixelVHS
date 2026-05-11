<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'usuario',
        'password',
        'telefono',
        'foto_perfil',
        'fecha_registro',
        'estado',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function socio()
    {
        return $this->hasOne(Socio::class, 'id_socio', 'id_usuario');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctores'
    ;
    protected $fillable = [
        'dni', // Agrega aquí otros atributos que quieres permitir en asignación masiva
        'nombres',
        'apellidos',
        'cod_especialidad',
        'sexo',
        'telefono',
        'correo',
        'activo',
        'created_at'
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'cod_doctor', 'id');
    }

}

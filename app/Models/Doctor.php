<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
        'cod_departamento',
        'sexo',
        'telefono',
        'correo',
        'activo',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'cod_doctor', 'id');
    }

    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'doctores', 'id', 'cod_especialidad');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'cod_departamento', 'id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'cod_doctor', 'id');
    }

}

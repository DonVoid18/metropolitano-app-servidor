<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';
    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'sexo',
        'password',
        'estado_civil',
        'direccion',
        'fecha_nacimiento',
        'imagen',
        'grupo_sangre',
        'correo',
        'activo',
        'created_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    public function citas()
    {
        return $this->hasMany(Cita::class, 'cod_paciente', 'id');
    }
}

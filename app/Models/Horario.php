<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'horarios';
    protected $fillable = [
        'cod_doctor',
        'entrada',
        'salida',
        'dias_semana' // Agrega aquí otros atributos que quieres permitir en asignación masiva

    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $fillable = ['dnialumno','nombrealumno', 'apellidoalumno','fechanacimiento','generoalumno','domicilio','localidad','provincia'];

    public function scopeNombres($query, $nombres) {
        if ($nombres) {
            return $query->where('nombrealumno','like',"%$nombres%");
        }
    }

    public function scopeApellidos($query, $apellidos) {
        if ($apellidos) {
            return $query->where('apellidoalumno','like',"%$apellidos%");
        }
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $fillable = ['dnialumno','nombrealumno', 'apellidoalumno','fechanacimiento','generoalumno','domicilio','localidad','provincia'];
}
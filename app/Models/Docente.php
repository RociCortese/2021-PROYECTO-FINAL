<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $table = 'docentes';
    protected $fillable = ['dni','nombre', 'apellido','fechanacimiento','genero','domicilio','localidad','provincia','estadocivil','telefono','email','legajo','especialidad'];
}

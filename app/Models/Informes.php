<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informes extends Model
{
    use HasFactory;
    protected $table = 'informes';
    protected $fillable = ['id_alumno','grado', 'espacio','nota','observacion','año','colegio_id'];
}
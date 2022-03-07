<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriosEvaluacion extends Model
{
    use HasFactory;
    protected $table = 'criteriosevaluacion';
    protected $fillable = ['criterio','id_espacio','id_año','id_grado','id_usuario','ponderacion','descripcion'];
}



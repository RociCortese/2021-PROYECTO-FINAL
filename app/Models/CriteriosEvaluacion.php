<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriosEvaluacion extends Model
{
    use HasFactory;
    protected $table = 'criteriosevaluacion';
    protected $fillable = ['criterio', 'descripcion','id_espacio','id_año','id_grado'];


    public function scopeespecialidad($query, $especialidad) {

        if ($especialidad) {
            return $query->where('id_espacio','like',"%$especialidad%");
        }
    }
    public function scopeaño($query, $añoescolar) {

        if ($añoescolar) {
            return $query->where('id_año','like',"%$añoescolar%");
        }
    }
}
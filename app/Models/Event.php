<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table= 'event';

    //
    protected $fillable = [
        'id','titulo', 'tipo', 'descripcion', 'lugar','fecha','participantes'
    ];

    public $timestamps = false;
}

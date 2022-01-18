<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table= 'evento';

    protected $fillable = [
        'titulo', 'descripcion', 'fecha','tipo','lugar','participantes',
    ];

    public $timestamps = false;
}
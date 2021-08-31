<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class File extends Model
{
    use HasFactory;
    protected $fillable= ['file'];
    protected $primaryKey = 'id';



 public function user()
    {
     return $this->hasOne(User::class, 'file_id', 'id');
    }
}

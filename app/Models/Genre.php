<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;
    protected $table = 'genre';
    protected $primaryKey = 'id_genre';
    public $timestamps = false;
}

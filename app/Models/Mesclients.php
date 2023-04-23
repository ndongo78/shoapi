<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesclients extends Model
{
    use HasFactory;
    protected $fillable=['user_id','email','sujet','message'];
}

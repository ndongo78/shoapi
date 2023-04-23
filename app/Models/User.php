<?php

namespace App\Models;

use App\Models\AvisUser;
use App\Models\Favorite;
use App\Models\Mesclient;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
         'prenom',
        'email',
        'password',
        'telephone',
        'addresse',
        'react_token'
    ];

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles(){
      return  $this->belongsToMany('App\Models\Article');
    }

    public function mesClient(){

      return  $this->belongsToMany(Mesclient::class);
    }

    public function favorites(){

      return $this->hasMany(Favorite::class);
  }

  public function avisUsers(){

    return $this->hasMany(AvisUser::class);
}
}

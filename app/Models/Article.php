<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable=['title','description','category_id','price','image','colors','taille'];
    
    protected $casts=[
      "colors"=>'array',
      "taille"=>'array'
    ];

    public function category(){

        return $this->belongsTo(Category::class);
    }

    public function users(){
      return  $this->belongsToMany('App\Models\user');
    }
}

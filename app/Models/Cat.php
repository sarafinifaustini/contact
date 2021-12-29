<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;
     protected $fillable = ['parent_id','category'];
    

    public function user(){
       return $this->hasMany(User::class);
    }
    public function children(){
        return $this->hasMany(Cat::class,'parent_id');
    }
}

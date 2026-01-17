<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areacustomer extends Model
{
    use HasFactory;
    protected $fillable = ['area'];

    public function consolidates(){
        return $this->hasMany(Consolidate::class);
    }
}

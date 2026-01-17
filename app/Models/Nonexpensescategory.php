<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nonexpensescategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'nonexpenses',
        'description'
    ];
    public function consolidates(){
        return $this->hasMany(Consolidate::class);
    }
}

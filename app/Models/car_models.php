<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car_models extends Model
{
    use HasFactory;

    protected $table = 'car_models';

    protected $fillable = ['name'];

    /*public function state(){
        return $this->belongsTo(State::class);
    }*/
}

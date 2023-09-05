<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marks extends Model
{
    use HasFactory;

    protected $table = 'marks';

    protected $fillable = ['name'];

    public function years(){
        return $this->hasMany(years::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    protected $fillable = ['id', 'birth_date', 'status', 'role', 'score', 'users_id','date_activi', 'last_activity'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

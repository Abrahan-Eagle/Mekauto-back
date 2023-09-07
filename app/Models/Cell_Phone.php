<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cell_Phone extends Model
{
    protected $table = 'cell_phones';
    protected $fillable = [
        'id',
        'cell_phone_number',
        'primary_phone_number',
        'cell_phone_verified_at',
        'status',
        'profile_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

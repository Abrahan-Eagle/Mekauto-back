<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'stock', 'price', 'status', 'level', 'advertising', 'img', 'url_video', 'date_activi', 'last_activity'];

}

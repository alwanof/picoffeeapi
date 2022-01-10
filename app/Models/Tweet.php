<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;


    protected $fillable = ['user_id','tweet'];

    public function comment ()
    {
        return $this->hasMany(Comment::class);
    }

    public function user ()

    {
        return $this->belongsTo(User::class);
    }
    public function like ()
    {
        return $this->hasMany(Like::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    // protected $table = 'users';
    use HasFactory;
    protected $fillable = ['title', 'body', 'user_id'];

    public function getInfoUser(){
        return $this->belongsTo(User::class, 'user_id'); //xem note ngày 2/11/25
    }
}

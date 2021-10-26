<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Media()
    {
        return $this->hasMany(Media::class);
    }

    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function all_comment() {
        return $this->Comments()->where('parent_id','=', 0);
    }
}

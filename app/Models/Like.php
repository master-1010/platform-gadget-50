<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['post_id', 'token'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

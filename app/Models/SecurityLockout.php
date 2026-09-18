<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLockout extends Model
{
    protected $fillable = ['user_id', 'locked_until', 'reason'];

    protected $casts = ['locked_until' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

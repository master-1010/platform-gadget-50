<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; use Illuminate\Notifications\Notifiable; use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable { use HasFactory,Notifiable; protected $fillable=['name','username','email','password','role','bio','phone','address']; protected $hidden=['password','remember_token']; protected function casts(): array{return ['email_verified_at'=>'datetime','password'=>'hashed'];} public function posts(){return $this->hasMany(Post::class);} public function isAdmin(): bool{return $this->role==='admin';} }

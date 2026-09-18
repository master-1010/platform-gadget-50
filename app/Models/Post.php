<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model {use SoftDeletes; protected $fillable=['title','slug','excerpt','content','category_id','featured_image','external_image_url','anonymous','status','rejection_reason']; protected $casts=['anonymous'=>'boolean','published_at'=>'datetime']; public function user(){return $this->belongsTo(User::class);} public function category(){return $this->belongsTo(Category::class);} public function comments(){return $this->hasMany(Comment::class);} public function likes(){return $this->hasMany(Like::class);} public function scopePublished($q){return $q->where('status','approved')->whereNotNull('published_at');} }

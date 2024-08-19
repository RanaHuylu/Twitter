<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = true;


    protected $fillable = [
        'user_id',
        'content',
        'post_type_id',
        'like_count',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postMedia()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedByUser()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}

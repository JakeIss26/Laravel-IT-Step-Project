<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model\Photo;
use Illuminate\Database\Eloquent\Model\Comment;
use Illuminate\Database\Eloquent\Model\Like;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Post extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id', 'publication_time'];


    public function photos() : HasMany
    {
        return $this->hasMany(Photo::class, 'PostId', 'Id');
    }


    public function comments() : HasMany 
    {
        return $this->hasMany(Comment::class, 'PostId', 'Id');
    }


    public function likes() : HasMany
    {
        return $this->hasMany(Like::class, 'PostId', 'Id');
    }


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'UserId');
    }

}

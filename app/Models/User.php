<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model\Post;
use Illuminate\Database\Eloquent\Model\FS;
use Illuminate\Database\Eloquent\Model\Group;
use Illuminate\Database\Eloquent\Model\Photo;
use Illuminate\Database\Eloquent\Model\Comment;
use Illuminate\Database\Eloquent\Model\Like;
use Illuminate\Database\Eloquent\Model\User_Group;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'birth_date'];


    public function posts() : HasMany
    {
        return $this->hasMany(Post::class, 'UserId', 'Id');
    }


    public function followers() : HasMany
    {
        return $this->hasMany(FS::class, 'FollowerId', 'Id');
    }


    public function subscriptions() : HasMany
    {
        return $this->hasMany(FS::class, 'AuthorId', 'Id');
    }


    public function groups() : HasMany
    {
        return $this->hasMany(Group::class, 'Owner', 'Id');
    }


    public function photos() : HasMany
    {
        return $this->hasMany(Photo::class, 'UserId', 'Id');
    }


    public function comments() : HasMany 
    {
        return $this->hasMany(Comment::class, 'AuthorId', 'Id');
    }


    public function likes() : HasMany
    {
        return $this->hasMany(Like::class, 'UserId', 'Id');
    }

    public function user_groups() : HasMany
    {
        return $this->hasMany(User_Group::class, 'UserId', 'Id');
    }
}

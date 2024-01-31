<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\FS;
use App\Models\Group;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User_Group;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $fillable = ['login', 'password', 'birth_date', 'name', 'email', 'avatar_path'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    
    public function posts() 
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }


    public function followers() : HasMany
    {
        return $this->hasMany(FS::class, 'author_id', 'id');
    }


    public function subscriptions() : HasMany
    {
        return $this->hasMany(FS::class, 'follower_id', 'id');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Post extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id', 'publication_time'];


    public function photos() : HasMany
    {
        return $this->hasMany(Photo::class, 'PostId', 'Id');
    }


    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }


    public function likes() : HasMany
    {
        return $this->hasMany(Like::class, 'PostId', 'Id');
    }


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

}

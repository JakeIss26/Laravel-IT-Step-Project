<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Model\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id', 'publication_time'];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'UserId');
    }


    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'Id', 'PostId');
    }
}

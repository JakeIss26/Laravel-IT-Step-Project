<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Model\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'author_id'];


    public function author_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'AuthorId');
    }


    public function author_user() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'Id', 'PostId');
    }
}

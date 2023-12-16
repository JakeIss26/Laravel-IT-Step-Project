<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'author_id'];


    public function author_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'AuthorId');
    }


    // public function author_user() : BelongsTo
    // {
    //     return $this->belongsTo(Post::class, 'Id', 'PostId');
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FS extends Model
{
    use HasFactory;
    protected $fillable = ['author_id', 'follower_id'];


    public function author_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'AuthorId');
    }


    public function follower_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'FollowerId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FS extends Model
{
    use HasFactory;
    protected $table = 'followers_and_subscriptions';
    protected $fillable = ['author_id', 'follower_id'];


    public function author_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'author_id');
    }


    public function follower_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'follower_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id', 'action_name', 'status'];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'UserId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Model\Group;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User_Group extends Model
{
    use HasFactory;
    protected $fillable = ['group_id', 'user_id'];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'UserId');
    }


    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class, 'Id', 'GroupId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\User_Group;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'owner'];


    public function user_groups() : HasMany
    {
        return $this->hasMany(User_Group::Class, 'GroupId', 'Id');
    }


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Id', 'Owner');
    }
}

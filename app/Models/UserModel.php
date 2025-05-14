<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Authenticatable
{
    protected $table = 'm_user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'id_level',
        'username',
        'name',
        'password',
        'photo_profile',
    ];

    protected $hidden = [
        'password',
    ];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }
}
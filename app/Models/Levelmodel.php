<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    protected $table = 'm_level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'id_level');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = 'm_level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    public function users()
    {
        return $this->hasMany(UserModel::class, 'id_level', 'id_level');
    }

    public function kriteria()
    {
        return $this->hasMany(KriteriaModel::class, 'id_level');
    }
}
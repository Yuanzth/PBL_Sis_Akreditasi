<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiModel extends Model
{
    protected $table = 't_validasi';
    protected $primaryKey = 'id_validasi';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria');
    }
}

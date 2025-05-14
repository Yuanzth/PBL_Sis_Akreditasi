<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarModel extends Model
{
    protected $table = 't_komentar';
    protected $primaryKey = 'id_komentar';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria');
    }
}

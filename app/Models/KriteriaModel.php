<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaModel extends Model
{
    protected $table = 'm_kriteria';
    protected $primaryKey = 'id_kriteria';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailKriteria()
    {
        return $this->hasMany(DetailKriteriaModel::class, 'id_kriteria');
    }

    public function validasi()
    {
        return $this->hasOne(ValidasiModel::class, 'id_kriteria');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarModel::class, 'id_kriteria');
    }

    public function generatedDocument()
    {
        return $this->hasOne(GeneratedDocumentModel::class, 'id_kriteria');
    }
}

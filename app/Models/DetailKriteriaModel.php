<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKriteriaModel extends Model
{
    protected $table = 'm_detail_kriteria';
    protected $primaryKey = 'id_detail_kriteria';
    public $timestamps = false;

    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKriteriaModel::class, 'id_kategori_kriteria');
    }

    public function dataPendukung()
    {
        return $this->hasMany(DataPendukungModel::class, 'id_detail_kriteria');
    }
}

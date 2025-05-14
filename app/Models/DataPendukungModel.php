<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPendukungModel extends Model
{
    protected $table = 't_data_pendukung';
    protected $primaryKey = 'id_data_pendukung';
    public $timestamps = false;

    public function detailKriteria()
    {
        return $this->belongsTo(DetailKriteriaModel::class, 'id_detail_kriteria');
    }

    public function gambar()
    {
        return $this->hasMany(GambarModel::class, 'id_data_pendukung');
    }
}

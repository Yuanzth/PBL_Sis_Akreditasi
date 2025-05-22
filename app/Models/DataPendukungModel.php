<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPendukungModel extends Model
{
    protected $table = 't_data_pendukung';
    protected $primaryKey = 'id_data_pendukung';
    protected $fillable = ['id_detail_kriteria', 'nama_data', 'deskripsi_data', 'hyperlink_data'];
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

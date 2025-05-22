<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarModel extends Model
{
    protected $table = 't_gambar';
    protected $primaryKey = 'id_gambar';
    protected $fillable = ['id_data_pendukung', 'gambar'];
    public $timestamps = false;

    public function dataPendukung()
    {
        return $this->belongsTo(DataPendukungModel::class, 'id_data_pendukung');
    }
}

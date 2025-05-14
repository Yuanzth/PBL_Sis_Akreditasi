<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKriteriaModel extends Model
{
    protected $table = 'm_kategori_kriteria';
    protected $primaryKey = 'id_kategori_kriteria';
    public $timestamps = false;

    public function detailKriteria()
    {
        return $this->hasMany(DetailKriteriaModel::class, 'id_kategori_kriteria');
    }
}

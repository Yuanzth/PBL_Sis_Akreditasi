<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaModel extends Model
{
    protected $table = 'm_kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $fillable = ['id_kriteria', 'id_level', 'nama_kriteria', 'status_selesai', 'created_at', 'updated_at'];
    public $timestamps = true;

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level');
    }

    public function detailKriteria()
    {
        return $this->hasMany(DetailKriteriaModel::class, 'id_kriteria');
    }

    public function validasi()
    {
        return $this->hasMany(ValidasiModel::class, 'id_kriteria', 'id_kriteria');
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
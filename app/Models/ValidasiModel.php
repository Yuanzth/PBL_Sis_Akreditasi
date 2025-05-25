<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiModel extends Model
{
    protected $table = 't_validasi';
    protected $primaryKey = 'id_validasi';
    protected $fillable = ['id_user', 'id_kriteria', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
    }
}
?>
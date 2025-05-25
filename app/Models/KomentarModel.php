<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarModel extends Model
{
    protected $table = 't_komentar';
    protected $primaryKey = 'id_komentar';
    protected $fillable = ['id_user', 'id_kriteria', 'komentar', 'created_at', 'updated_at'];

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
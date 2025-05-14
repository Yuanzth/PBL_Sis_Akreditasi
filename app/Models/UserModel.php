<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute; 

use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable

class UserModel extends Model
{
    protected $table = 'm_user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level');
    }

    public function kriteria()
    {
        return $this->hasOne(KriteriaModel::class, 'id_user');
    }

    public function validasi()
    {
        return $this->hasMany(ValidasiModel::class, 'id_user');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarModel::class, 'id_user');
    }

    public function finalDocument()
    {
        return $this->hasOne(FinalDocumentModel::class, 'id_user');
    }
}

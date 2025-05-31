<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalDocumentModel extends Model
{
    protected $table = 't_final_document';
    protected $primaryKey = 'id_final_document';
    public $timestamps = false;

    protected $fillable = ['id_user', 'final_document'];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user'); // Ubah ke UserModel dan tentukan primary key
    }
}
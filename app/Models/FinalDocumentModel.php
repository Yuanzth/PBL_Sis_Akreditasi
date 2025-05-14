<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalDocumentModel extends Model
{
    protected $table = 't_final_document';
    protected $primaryKey = 'id_final_document';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

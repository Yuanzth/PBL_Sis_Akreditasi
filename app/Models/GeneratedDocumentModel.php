<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedDocumentModel extends Model
{
    protected $table = 't_generated_document';
    protected $primaryKey = 'id_generated_document';
    public $timestamps = false;

    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria');
    }
}

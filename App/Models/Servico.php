<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servicos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'id_contrato', 'id');
    }
}

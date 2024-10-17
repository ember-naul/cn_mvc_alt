<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contratos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'id_profissional', 'id');
    }
}

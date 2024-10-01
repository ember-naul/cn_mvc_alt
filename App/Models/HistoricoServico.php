<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoServico extends Model
{
    protected $table = 'historico_servicos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'id_servico', 'id');
    }
}

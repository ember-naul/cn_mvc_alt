<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoCliente extends Model
{
    protected $table = 'avaliacoes_clientes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'id_servico', 'id');
    }
}
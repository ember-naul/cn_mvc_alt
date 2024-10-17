<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function mensagem()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'id_profissional', 'id');
    }
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'id_chat', 'id');
    }
}

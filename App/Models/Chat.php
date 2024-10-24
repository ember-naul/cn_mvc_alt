<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'id_contrato', 'id');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_chat', 'id');
    }
}

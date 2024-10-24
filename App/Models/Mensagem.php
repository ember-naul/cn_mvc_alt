<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'id_chat', 'id');
    }
}

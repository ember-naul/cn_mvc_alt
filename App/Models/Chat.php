<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function chat()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'id_profissional', 'id');
    }
}

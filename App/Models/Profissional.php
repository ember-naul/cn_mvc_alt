<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    protected $table = 'profissionais';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
    public function habilidades()
    {
        return $this->belongsToMany(Habilidade::class, 'profissionais_habilidades', 'id_profissional', 'id_habilidade');
    }
    
}
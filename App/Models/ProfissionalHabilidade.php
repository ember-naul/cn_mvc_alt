<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfissionalHabilidade extends Model
{
    protected $table = 'profissionais_habilidades';
    protected $primaryKey = 'id'; // Se existir um campo 'id'
    protected $fillable = ['id_profissional', 'id_habilidade'];
    public $timestamps = false;


    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'id_profissional');
    }

    public function habilidade()
    {
        return $this->belongsTo(Habilidade::class, 'id_habilidade');
    }
}


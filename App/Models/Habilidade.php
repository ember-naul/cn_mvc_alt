<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidade extends Model
{
    protected $table = 'habilidades';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function profissionais()
{
    return $this->belongsToMany(Profissional::class, 'profissionais_habilidades', 'id_habilidade', 'id_profissional');
}

}
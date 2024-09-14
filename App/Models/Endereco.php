<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos'; // Nome da tabela
    protected $primaryKey = 'id'; // Nome da tabela
    protected $fillable = ['id_cliente', 'cep', 'bairro', 'cidade', 'endereco', 'numero']; // Campos preenchíveis
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

<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamentos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'id_servico', 'id');
    }
}

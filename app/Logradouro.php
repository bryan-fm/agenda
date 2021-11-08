<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bairro;
use DB;

class Logradouro extends Model
{
    public $timestamps = false;
    protected $table = 'logradouro';

    public static function exists($cidade, $uf, $bairro, $logradouro)
    {
        return DB::table('logradouro as l')
        ->selectRaw('l.id')
        ->join('bairro as b', 'b.id', '=', 'l.bairro_id')
        ->join('cidade as cd', 'cd.id', '=', 'b.cidade_id')
        ->join('uf', 'uf.id', '=', 'cd.uf_id')
        ->where('uf.id', '=', $uf)
        ->where('b.id', '=', $bairro)
        ->where('cd.id', '=', $cidade)
        ->where('l.nome', '=', $logradouro);

    }

    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'bairro_id');
    }
}

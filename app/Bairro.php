<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Bairro extends Model
{
    public $timestamps = false;
    protected $table = 'bairro';

    public static function exists($cidade, $uf, $bairro)
    {
        return DB::select('
        select b.id from bairro as b
        join cidade c on c.id = b.cidade_id
        join uf on uf.id = c.uf_id
        where c.id = ? and
        uf.id = ? and b.nome = ?',[$cidade,$uf, $bairro]);
    }

}

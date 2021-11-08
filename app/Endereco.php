<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Endereco extends Model
{
    public $timestamps = false;
    protected $table = 'endereco';

    public static function exists($contato, $logradouro)
    {
        $end = DB::table('endereco as e')
        ->select('e.id')
        ->where('e.contato_id', '=', $contato)
        ->where('e.logradouro_id', '=', $logradouro);

        return $end;
    }
}

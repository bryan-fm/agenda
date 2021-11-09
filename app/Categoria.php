<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contato;

class Categoria extends Model
{
    public $timestamps = false;
    protected $table = 'categoria';

    public function contatos()
    {
        return $this->hasMany(Contato::class,'contato_id','id');
    }
}

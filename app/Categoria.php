<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contato;

class Categoria extends Model
{
    public $timestamps = false;
    protected $table = 'categoria';

    public function contatos_vinculados()
    {
        return $this->hasMany(Contato::class,'categoria_id','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Telefone;
use App\Endereco;

class Contato extends Model
{
    public $timestamps = false;
    protected $table = 'contatos';

    public function telefones()
    {
        return $this->hasMany(Telefone::class,'contato_id','id');
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class,'contato_id','id');
    }

}


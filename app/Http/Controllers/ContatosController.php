<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contato;
use App\Telefone;
use App\UF;
use App\Cidade;
use App\Bairro;
use App\Logradouro;
use App\Endereco;
use Auth;
use DB;

class ContatosController extends Controller
{

    public function index()
    {
        $user_id = Auth::id();
        $contatos = Contato::all()->where('user_id', '=', $user_id);
        return view('contatos.ContatosGrid',[
            'contatos' => $contatos
        ]);

    }

    public function addForm()
    {
        return view('contatos.ContatosForm',[
            'action' => 'add'
        ]);
    }

    public function editForm($id)
    {
        $contato = Contato::find($id);
        return view('contatos.ContatosForm',[
            'action' => 'edit',
            'contato' => $contato
        ]);
    }

    public function store(Request $request)
    {
        $this->validaForm($request);

        $user_id = Auth::id();
        
        try {
            DB::beginTransaction();

            $contato = new Contato();
            if($request->id != 0)
            {
                $contato = Contato::find($request->id);
                Telefone::where('contato_id', $request->id)->delete();
                Endereco::where('contato_id', $request->id)->delete();
            }
                
            $contato->nome = $request->nome;
            $contato->apelido = $request->apelido;
            $contato->user_id = $user_id;
            $contato->save();


            foreach($request->telefones as $num)
            {
                $telefone = new Telefone();
                $telefone->numero = $num;
                $telefone->contato_id = $contato->id;
                $telefone->save();
            }

            foreach($request->enderecos as $add)
            {
                $estado = UF::select('id')->where('sigla', '=',$add['estado'])->get();
                $cidade = Cidade::exists($add['cidade'], $estado[0]['id']);
                if(sizeof($cidade) == 0)
                {
                    $n_cidade = New Cidade();
                    $n_cidade->nome = $add['cidade'];
                    $n_cidade->uf_id = $estado[0]['id'];
                    $n_cidade->save();

                    $cidade = $n_cidade->id;
                }
                else
                {
                    $cidade = $cidade[0]->id;
                }

                $bairro = Bairro::exists($cidade, $estado[0]['id'], $add['bairro']);
                if(sizeof($bairro) == 0)
                {
                    $n_bairro = New Bairro();
                    $n_bairro->nome = $add['bairro'];
                    $n_bairro->cidade_id = $cidade;
                    $n_bairro->save();

                    $bairro = $n_bairro->id;
                }
                else
                {
                    $bairro = $bairro[0]->id;
                }
                
                $logradouro = Logradouro::exists($cidade, $estado[0]['id'], $bairro, $add['log'])->get();
                if(sizeof($logradouro) == 0)
                {
                    $n_logradouro = New Logradouro();
                    $n_logradouro->nome = $add['log'];
                    $n_logradouro->bairro_id = $bairro;
                    $n_logradouro->cep = $add['cep'];
                    $n_logradouro->save();

                    $logradouro = $n_logradouro->id;
                }
                else
                {
                    $logradouro = $logradouro[0]->id;
                }

                $endereco = Endereco::exists($contato->id, $logradouro)->get();
                if($endereco == null)
                {
                    return 'Endereço Já Cadastrado para este contato';
                }

                $endereco = new Endereco();
                $endereco->contato_id = $contato->id;
                $endereco->logradouro_id = $logradouro;
                $endereco->numero = $add['num'];
                $endereco->save();

            }


        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);

        }

        DB::commit();
        if($request->id != 0)
            return response()->json(['success' => true, 'message' => 'Registro Editado com Sucesso!']);

        return response()->json(['success' => true, 'message' => 'Registro Cadastrado com Sucesso!']);
    }


    public function delete($id)
    {
        
    }
}

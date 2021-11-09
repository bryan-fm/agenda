<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contato;
use App\Categoria;
use Auth;
use DB;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Categoria::all();

        return view('categoria.CategoriaGrid',[
            'categorias' => $categorias
        ]);

    }

    public function addForm()
    {
        return view('categoria.CategoriaForm');
    }

    public function editForm($id)
    {
        $categoria = Categoria::find($id);
        return view('categoria.CategoriaForm',[
            'categoria' => $categoria
        ]);
    }

    public function store(Request $request)
    {
        $this->validaForm($request);
        
        try {

            DB::beginTransaction();

            $categoria = new Categoria();
            if(Categoria::find($request->id))
                $categoria = Categoria::find($request->id);
            $categoria->descricao = $request->descricao;
            $categoria->save();

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
        try 
        {
            DB::beginTransaction();
            Categoria::find($id)->delete();
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);

        }
        DB::commit();
        return response()->json(['success' => true, 'message' => 'Registro Deletado com Sucesso!']);

    }

    public function validaForm(Request $request)
    {

        $customMessages = [
            'descricao.required' => 'A Descrição deve ser informada',
        ];


        $this->validate($request, [
            'descricao' => 'required|string',
        ], $customMessages);
        
    }


}

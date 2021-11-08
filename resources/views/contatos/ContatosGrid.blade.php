@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Contatos  <a href="/contatos/addFormContatos" class="btn btn-info float-right" role="button">Adicionar Contato</a> </div> 
                    <div class="card-body">
                        <div class="table-responsive border-0">
                            <table class="table table-hover" style="margin-bottom: inherit">

                                @foreach($contatos as $key => $data)
                                    <tr>    
                                        <td>{{$data->id}}</th>
                                        <td><a href="/contatos/editFormContatos/{{$data->id}}">{{$data->nome}}</a></th>
                                        <td>{{$data->apelido}}</th>               
                                    </tr>
                                @endforeach

                            </table>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categorias <a href="/categoria/addFormCategoria" class="btn btn-info float-right" role="button">Adicionar Categoria</a>
                </div> 
                    <div class="card-body">
                        <div class="table-responsive border-0">
                            <table class="table table-hover" id="categorias" style="margin-bottom: inherit">

                                @foreach($categorias as $key => $data)
                                    <tr>    
                                        <td>{{$data->id}}</td>
                                        <td><a href="/categoria/editFormCategoria/{{$data->id}}">{{$data->descricao}}</a></td>  
                                        <td><a href="/categoria/deleteCategoria/{{$data->id}}" class="btn btn-danger float-right" role="button">Deletar</a></td>         
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

<script>
    $(document).ready(function () 
    {

    }
</script>

@endsection
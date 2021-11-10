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
                                        <td><a class="btn btn-danger float-right delete" id="{{$data->id}}" role="button">Deletar</a></td>         
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

        $('.delete').on('click', function(event){

            url = '/categoria/deleteCategoria/'+ event.target.id;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "GET",
                url : url, 
                data:{
                },
            success: function(resposta){
                if (resposta.success){
                    alert(resposta.message);
                    window.location.href = '/categoria';
                }else{
                    alert(resposta.message);
                }
            },
            error: function(error)
            {
                alert(JSON.stringify(error));
            }
            });
        });

    });
</script>

@endsection
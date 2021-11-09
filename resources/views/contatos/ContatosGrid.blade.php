@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Contatos  <a href="/contatos/addFormContatos" class="btn btn-info float-right" role="button">Adicionar Contato</a>
                    <label for="pesquisa_n" class="col-md-2 text-md-right">Nome:</label> 
                    <input id="pesquisa_n"class=" col-md-2">

                    <label for="pesquisa_c" class="col-md-2 text-md-right">Categoria:</label> 
                    <input id="pesquisa_c"class=" col-md-2">
                </div> 
                    <div class="card-body">
                        <div class="table-responsive border-0">
                            <table class="table table-hover" id="contatos" style="margin-bottom: inherit">

                                @foreach($contatos as $key => $data)
                                    <tr>    
                                        <td>{{$data->id}}</td>
                                        <td><a href="/contatos/editFormContatos/{{$data->id}}">{{$data->nome}}</a></td>
                                        <td>{{$data->apelido}}</td>  
                                        <td>{{$data->categoria->descricao}}</td>        
                                        <td><a href="/contatos/deleteContatos/{{$data->id}}" class="btn btn-danger float-right" role="button">Deletar</a></td>             
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

        $('#pesquisa').on('change', function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "GET",
                url : '/contatos/filtrarContatos', 
                data:{
                    nome:$('#pesquisa').val(),
                },
            success: function(resposta){
                if (resposta.success){

                    var list = document.getElementById("contatos"); 
                    list.innerHTML = '';

                    resposta.message.forEach(function(cont){

                        $("#contatos").append('<tr>');
                        $("#contatos").append('<td>' + cont.id + '</td>');
                        $("#contatos").append('<td><a href="/contatos/editFormContatos/'+ cont.id +'">' + cont.nome +'</td>');  
                        $("#contatos").append('<td>' + cont.apelido + '</td>');
                        $("#contatos").append('<td>' + cont.categoria + '</td>');
                        $("#contatos").append('<td><a href="/contatos/deleteContatos/' + cont.id + '"' + 'class="btn btn-danger float-right" role="button">Deletar</a></td>')
                        $("#contatos").append('</tr>');

                    });

                }else{
                    alert(JSON.stringify(resposta));
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
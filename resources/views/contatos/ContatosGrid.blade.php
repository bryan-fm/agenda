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
                    <select id="pesquisa_c" class="col-md-3 text-md">
                        <option value=0>Selecione uma Categoria</option>
                        @foreach ($categorias as $cat)
                            <option value="{{$cat->id}}">{{$cat->descricao}}</option>
                        @endforeach
                    </select>
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
                                        <td><a class="btn btn-danger float-right delete" id='{{$data->id}}' role="button">Deletar</a></td>             
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
        @if(sizeof($categorias) == 0)
            return alert("O Sistema ainda não Possui Categorias cadastradas, faça o cadastro de alguma para vincular aos contatos");
        @endif

        $('#pesquisa_n').on('change', function(){
            filtraContatos(1)
        });

        $('#pesquisa_c').on('change', function(){
            filtraContatos(2)
        });

        $('.delete').on('click', function(event){

            
            url = '/contatos/deleteContatos/'+ event.target.id;
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
                    window.location.href = '/contatos';
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

        function filtraContatos(tipo)
        {
            if(tipo == 1) 
            {
                filtro = $('#pesquisa_n').val();
                url = '/contatos/filtrarContatosNome';
            }
            else if(tipo == 2)
            {
                filtro = $('#pesquisa_c').val();
                url = '/contatos/filtrarContatosCategoria';
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "GET",
                url : url, 
                data:{
                    filtro:filtro
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
                        $("#contatos").append('<td><a href="/contatos/deleteContatos/' + cont.id + '"' + 'class="btn btn-danger float-right delete" role="button">Deletar</a></td>')
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
        }

    });

</script>

@endsection
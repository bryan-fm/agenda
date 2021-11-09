@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Contatos
                </div> 
                    <div class="card-body">

                    <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Nome</label> 
                            <div class="col-md-6">
                                <input id="nome" required="required" autofocus="autofocus" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Apelido</label> 
                            <div class="col-md-6">
                                <input id="apelido" required="required" autofocus="autofocus" class="form-control">
                            </div>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                Telefones
                                <div style="float:right; text-align: right;">
                                    <a class="btn btn-info float-right" style="display:inline-block" role="button" id='add_tel'>Adicionar Telefone</a>
                                    <a class="btn btn-info float-right" style="display:inline-block" role="button" id='del_tel'>Remover Telefone</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row" id="telefones">
                                
                                </div>
                            </div>
                        </div> 

                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                Endereços
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label for="cep" class="col-form-label ">CEP:</label> 
                                        <input id="cep" class="form-control col-md-12 clear-cep">
                                    </div>

                                    <div class="col-md-8">
                                        <label for="logradouro" class="col-form-label">Logradouro:</label> 
                                        <input id="logradouro" class="form-control col-md-12 mr-5 clear-cep">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="bairro" class="col-form-label">Bairro:</label> 
                                        <input id="bairro" class="form-control col-md-12 clear-cep">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="cidade" class="col-form-label">Cidade:</label> 
                                        <input id="cidade" class="form-control col-md-12 mr-5 clear-cep">
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label for="uf" class="col-form-label">UF:</label> 
                                        <input id="uf" class="form-control col-md-12 mr-5 clear-cep">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="numero" class="col-form-label">Número:</label> 
                                        <input id="numero" class="form-control col-md-12 clear-cep">
                                    </div>

                                    <div class="col-md-1"> 
                                        <Button class="btn btn-success form-control col-md-12 bottom" style="margin-top: 35px;" id="add_endereco"> + </button>
                                    </div>

                                </div>

                                <br>
                                <div id="jsGrid"></div>
                            </div>
                        </div> 

                        <button id="btn-add-edit"  class="btn btn-primary float-right" style="margin-top: 40px;">
                            <i class="fa fa-btn fa-envelope"></i>
                            Salvar
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () 
    {
        
        $("#jsGrid").jsGrid({
        width: "100%",
        height: "400px",
 
        inserting: false,
        editing: true,
        sorting: true,
        paging: true,
 
 
        fields: [
            { name: "id", title: "ID", type: "text", visible: false},
            { name: "cep", title: "CEP", type:'text', width: '10%'},
            { name: "log", title: "Logradouro", type: "text", width: '30%'},
            { name: "num", title: "Número", type: "number", width: '7%' },
            { name: "bairro", title: "Bairro", type: "text", width: '25%' },
            { name: "cidade", title: "Cidade", type: "text",  width: '16%'},
            { name: "estado", title: "UF", type: "text",  width:'7%' },
            { type: "control", width: '5%'}
        ]
        });

        @if(isset($contato))
        {
            $('#nome').val('{{$contato->nome}}');
            $('#apelido').val('{{$contato->apelido}}');

            @foreach($contato->telefones as $telefone)
            {
                addTelInput('{{$telefone->numero}}');
            }
            @endforeach

            @foreach($contato->enderecos as $end)
            {
                $("#jsGrid").jsGrid("insertItem", 
                { 
                    cep: '{!!$end->logradouro->cep!!}',
                    log: '{!!$end->logradouro->nome!!}', 
                    num: '{!!$end->numero!!}', 
                    bairro: '{!!$end->logradouro->bairro->nome!!}', 
                    cidade: '{!!$end->logradouro->bairro->cidade->nome!!}',
                    estado: '{!!$end->logradouro->bairro->cidade->uf->sigla!!}',
                });
            }
            @endforeach

        }
        @endif

        $("#cep").inputmask({
                mask: ["99999-999"],
                keepStatic: true
            });

        function clearCep()
        {
            $('.clear-cep').val('');
        }

        function addTelMask()
        {
            $(".numero").inputmask({
                mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                keepStatic: true
            });
        }

        function addTelInput(num = 0)
        {
            var telefone = document.createElement("input");
            telefone.type = "text"; telefone.value = ""; telefone.className = "numero col-md-3 form-control mr-4 ml-5 mb-2";

            if(num!= 0)
            {
                telefone.value = num;
            }

            document.getElementById('telefones').appendChild(telefone);

            addTelMask();
        }


        $('#add_tel').on('click',function(){
            addTelInput();
        });

        $('#del_tel').on('click',function(){

            if($('#telefones').children().length > 0)
            {
                var list = document.getElementById("telefones"); 
                list.removeChild(list.childNodes[list.childNodes.length -1]);
            }

        });

        $('#add_endereco').on('click',function(){

            cep = $('#cep').val();
            logradouro = $('#logradouro').val();
            numero = $('#numero').val();
            bairro = $('#bairro').val();
            cidade = $('#cidade').val();
            uf = $('#uf').val();

            if(cep === "" || logradouro === "" || numero === "" ||  bairro === "" || cidade === "" || uf === "")
            {
                return alert("Informe todos os dados do Endereço");
            }

            $("#jsGrid").jsGrid("insertItem", { cep: cep, log: logradouro, num: numero, bairro: bairro, cidade: cidade,estado:uf })

            clearCep();

        });


        $('#cep').on('change', function(){

            let cep = $('#cep').val().replace('-','');
            if(cep == "" || cep.length != 8)
            {
                return alert("CEP Informado Incorretamente");
            }

            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

            if (!("erro" in dados)) {
                //Atualiza os campos com os valores da consulta.
                $('#logradouro').val(dados.logradouro)
                $('#bairro').val(dados.bairro)
                $('#cidade').val(dados.localidade)
                $('#uf').val(dados.uf)
            } //end if.
            else {
                //CEP pesquisado não foi encontrado.
                alert("CEP não encontrado.");
            }
            });
        });

        
        $('#btn-add-edit').on('click', function(){
            nome = $('#nome').val();
            apelido = $('#apelido').val();
            telefones = [];
            enderecos  = $("#jsGrid").jsGrid("option", "data");


            url = '/contatos/insertContatos';

            var form_tel = $(".numero");

            if(enderecos.length == 0)
            {
                return alert('Informe ao menos um endereço');
            }

            for(var i = 0; i < form_tel.length; i++){
                cur_num = $(form_tel[i]).val();
                cur_num = cur_num.replaceAll('_','');
                if(cur_num.length = "" || (cur_num.length < 14 || cur_num.length > 15))
                {
                    return alert('O Número' + cur_num + ' está errado ou incompleto, favor corrigir o mesmo ou removê-lo');
                }

                telefones.push($(form_tel[i]).val());
            }

            @if(isset($contato))
            {
                id = '{{$contato->id}}'
            }
            @else
            {
                id = 0;
            }
            @endif




            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: url, 
                data:{
                    nome:nome,
                    apelido:apelido,
                    telefones:telefones,
                    enderecos: enderecos,
                    id: id,
                },
            success: function(resposta){
                if (resposta.success){
                    alert(resposta.message, true);
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

    });

</script>

@endsection
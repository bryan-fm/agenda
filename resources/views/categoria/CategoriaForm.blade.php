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
                            <label for="email" class="col-md-4 col-form-label text-md-right">Descrição</label> 
                            <div class="col-md-6">
                                <input id="descricao" required="required" autofocus="autofocus" class="form-control">
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
        
    @if(isset($categoria))
    {
        $('#descricao').val('{!!$categoria->descricao!!}')
    }
    @endif

    $('#btn-add-edit').on('click', function(){

        descricao = $('#descricao').val();
        if(descricao == "")
        {
            return alert("Informe a Descrição");
        }

        @if(isset($categoria))
            {
                id = '{{$categoria->id}}'
            }
            @else
            {
                id = 0;
            }
            @endif

        url = '/categoria/insertCategoria';

        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: url, 
                data:{
                    descricao: descricao,
                    id:id
                },
            success: function(resposta){
                if (resposta.success){
                    alert(resposta.message, true);
                    window.location.href = '/categoria';
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
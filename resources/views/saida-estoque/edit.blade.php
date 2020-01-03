@extends('home')

@section('titulo','Editar Saída Estoque')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Saída Estoque</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form"
                              action="{{route('saida-estoque.update')}}" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" id="id" value="{{ $saidaEstoque->id }}">

                            <div class="form-group col-md-10{{ $errors->has('produto_id') ? ' has-error' : '' }}">
                                <label for="produto_id" class="control-label">Produto: </label>
                                <select class="form-control" data-live-search="true" id="produto_id"
                                        name="produto_id">
                                    <option data-tokens="ketchup mustard" value="">Selecione</option>
                                    @foreach($produto as $key=>$value)
                                        <option data-tokens="ketchup mustard"
                                                value="{{ $value->id }}" {{ $saidaEstoque->produto_id == $value->id ? 'selected' : ''}}> {{ $value->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-10 {{ $errors->has('unidade_medida_id') ? ' has-error' : '' }}">
                                <label for="unidade_medida_id" class="control-label">Unidade de Medida:</label>
                                <select class="form-control" data-live-search="true" id="unidade_medida_id"
                                        name="unidade_medida_id">
                                    <option data-tokens="ketchup mustard" value="">Selecione</option>
                                    @foreach($unidade_medida as $key=>$value)
                                        <option data-tokens="ketchup mustard"
                                                value="{{ $value->id }}" {{ $saidaEstoque->unidade_medida_id == $value->id ? 'selected' : ''}}> {{ $value->sigla }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('unidade_medida_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('unidade_medida_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('num_cupom') ? ' has-error' : '' }}">
                                <label for="num_cupom" class="control-label"> Cupom: </label>
                                <input id="num_cupom" type="number" class="form-control" name="num_cupom"
                                       value="{{ $saidaEstoque->num_cupom }}">
                                @if ($errors->has('num_cupom'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('num_cupom') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('qtd_minimo') ? ' has-error' : '' }}">
                                <label for="quantidade" class="control-label"> Quantidade: </label>
                                <input id="quantidade" type="number" class="form-control" name="quantidade"
                                       value="{{ $saidaEstoque->quantidade }}">
                                @if ($errors->has('quantidade'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('quantidade') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-5{{ $errors->has('val_unitario') ? ' has-error' : '' }}">
                                <label for="val_unitario" class="control-label"> Valor Unitário: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="val_unitario" type="text" class="form-control" name="val_unitario"
                                           value="{{ $saidaEstoque->val_unitario }}">
                                </div>
                                @if ($errors->has('val_unitario'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('val_unitario') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-5">
                                <label for="val_unitario" class="control-label"> Valor Total: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="total" type="text" class="form-control" name="total" disabled="disabled">
                                </div>
                            </div>

                            <div class="form-group col-md-10">
                                {!! csrf_field() !!}
                                <button type="submit" class="control-label btn btn-primary">Alterar</button>
                                <a class="control-label btn btn-danger" href="{{route('saida-estoque.show')}}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            jQuery("#quantidade, #val_unitario").change(function (e) {
                var form_data = new FormData();
                form_data.append('quantidade', $('#quantidade').val());
                form_data.append('val_unitario', $('#val_unitario').val());
                form_data.append('_token', '{{csrf_token()}}');
                $.ajax({
                    url: "{{ route('estoque.total') }}",
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#total').val(response);
                    },
                    error: function (xhr, status, error) {
                        console.log(status);
                    }
                });
            });

            jQuery("#quantidade").change();
            jQuery("#val_unitario").change();
        });
    </script>
@endsection
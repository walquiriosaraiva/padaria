@extends('home')

@section('titulo','Editar Entrada Estoque')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Entrada Estoque</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form"
                              action="{{route('entrada-estoque.update')}}" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" id="id" value="{{ $entradaEstoque->id }}">

                            <div class="form-group col-md-10{{ $errors->has('produto_id') ? ' has-error' : '' }}">
                                <label for="produto_id" class="control-label">Produto: </label>
                                <select class="form-control" data-live-search="true" id="produto_id"
                                        name="produto_id">
                                    <option data-tokens="ketchup mustard" value="">Selecione</option>
                                    @foreach($produto as $key=>$value)
                                        <option data-tokens="ketchup mustard"
                                                value="{{ $value->id }}" {{ $entradaEstoque->produto_id == $value->id ? 'selected' : ''}}> {{ $value->descricao }}</option>
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
                                                value="{{ $value->id }}" {{ $entradaEstoque->unidade_medida_id == $value->id ? 'selected' : ''}}> {{ $value->sigla }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('unidade_medida_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('unidade_medida_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('num_nota_fiscal') ? ' has-error' : '' }}">
                                <label for="num_nota_fiscal" class="control-label"> Nota Fiscal: </label>
                                <input id="num_nota_fiscal" type="number" class="form-control" name="num_nota_fiscal"
                                       value="{{ $entradaEstoque->num_nota_fiscal }}">
                                @if ($errors->has('num_nota_fiscal'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('num_nota_fiscal') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('qtd_minimo') ? ' has-error' : '' }}">
                                <label for="quantidade" class="control-label"> Quantidade: </label>
                                <input id="quantidade" type="number" class="form-control" name="quantidade"
                                       value="{{ $entradaEstoque->quantidade }}">
                                @if ($errors->has('quantidade'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('quantidade') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6{{ $errors->has('val_unitario') ? ' has-error' : '' }}">
                                <label for="val_unitario" class="control-label"> Valor Unitário: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="val_unitario" type="text" class="form-control" name="val_unitario"
                                           value="{{ $entradaEstoque->val_unitario }}">
                                </div>
                                @if ($errors->has('val_unitario'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('val_unitario') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10">
                                {!! csrf_field() !!}
                                <button type="submit" class="control-label btn btn-primary">Alterar</button>
                                <a class="control-label btn btn-danger" href="{{route('entrada-estoque.show')}}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
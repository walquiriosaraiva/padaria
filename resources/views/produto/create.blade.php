@extends('home')

@section('titulo','Cadastrar Produto')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastrar Produto</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form"
                              action="{{route('produto.store')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group col-md-10{{ $errors->has('descricao') ? ' has-error' : '' }}">
                                <label for="descricao" class="control-label">Descrição: </label>
                                <input id="descricao" type="text" class="form-control" name="descricao"
                                       value="{{ old('descricao') }}">
                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('descricao') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10 {{ $errors->has('unidade_medida_id') ? ' has-error' : '' }}">
                                <label for="unidade_medida_id" class="control-label">Unidade de Medida:</label>
                                <select class="form-control" data-live-search="true" id="unidade_medida_id"
                                        name="unidade_medida_id">
                                    <option data-tokens="ketchup mustard" value="">Selecione</option>
                                    @foreach($unidade_medida as $key=>$value)
                                        <option data-tokens="ketchup mustard"
                                                value="{{ $value->id }}"> {{ $value->sigla }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('unidade_medida_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('unidade_medida_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('qtd_minimo') ? ' has-error' : '' }}">
                                <label for="qtd_minimo" class="control-label"> Quantidade: </label>
                                <input id="qtd_minimo" type="number" min="1" class="form-control" name="qtd_minimo"
                                       value="{{ old('qtd_minimo') }}">
                                @if ($errors->has('qtd_minimo'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('qtd_minimo') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6{{ $errors->has('val_unitario') ? ' has-error' : '' }}">
                                <label for="val_unitario" class="control-label"> Valor Unitário: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="val_unitario" type="text" class="form-control" name="val_unitario"
                                           value="{{ old('val_unitario') }}">
                                </div>
                                @if ($errors->has('val_unitario'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('val_unitario') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10">
                                {!! csrf_field() !!}
                                <button type="submit" class="control-label btn btn-primary">Cadastrar</button>
                                <a class="control-label btn btn-danger" href="{{route('admin')}}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

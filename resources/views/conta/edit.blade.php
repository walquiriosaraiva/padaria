@extends('home')

@section('titulo','Editar Conta')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Conta</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form"
                              action="{{route('conta.update')}}" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" id="id" value="{{ $conta->id }}">
                            <div class="form-group col-md-10 {{ $errors->has('tc') ? ' has-error' : '' }}">
                                <label for="tc" class="control-label">Tipo de Conta:</label>
                                <select class="form-control" data-live-search="true" id="tc" name="tc">
                                    <option data-tokens="ketchup mustard" value="">Selecione</option>
                                    <option data-tokens="ketchup mustard" value="1" {{ $conta->tipo == 1? 'selected' : '' }}> Corrente</option>
                                    <option data-tokens="ketchup mustard" value="2" {{ $conta->tipo == 2 ? 'selected' : '' }}> Poupança</option>
                                </select>

                                @if ($errors->has('tc'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('tc') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('nc') ? ' has-error' : '' }}">
                                <label for="nc" class="control-label">Número da Conta: </label>
                                <input id="nc" type="text" class="form-control" name="nc" value="{{ $conta->numero }}">
                                @if ($errors->has('nc'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('nc') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10 {{ $errors->has('bc') ? ' has-error' : '' }}">
                                <label for="bc" class="control-label">Nome do Banco:</label>
                                <select class="form-control" data-live-search="true" id="bc" name="bc">
                                    <option data-tokens="ketchup mustard" value="">Selecione</option>
                                    @foreach($bancos as $key=>$value)
                                        <option data-tokens="ketchup mustard" value="{{ $key }}" {{ $value == $conta->banco ? 'selected' : '' }}> {{ $value }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('bc'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('bc') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('ac') ? ' has-error' : '' }}">
                                <label for="ac" class="control-label"> Agência: </label>
                                <input id="ac" type="text" class="form-control" name="ac" value="{{ $conta->agencia }}">
                                @if ($errors->has('ac'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('ac') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('sc') ? ' has-error' : '' }}">
                                <label for="sc" class="control-label"> Saldo da Conta: </label>

                                <input id="sc" type="text" class="form-control" name="sc" value="{{ $conta->saldo }}">

                                @if ($errors->has('sc'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('sc') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10">
                                {!! csrf_field() !!}
                                <button type="submit" class="control-label btn btn-primary">Alterar</button>
                                <a class="control-label btn btn-danger" href="{{route('admin')}}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
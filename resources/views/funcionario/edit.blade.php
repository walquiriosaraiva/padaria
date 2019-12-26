@extends('home')

@section('titulo','Editar Funcionário')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Funcionário</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form" action="{{route('funcionario.update')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group col-md-8 {{ $errors->has('cargo') ? ' has-error' : '' }}">
                                <label for="cargo" class="control-label" >Cargo:</label>
                                <select class="form-control" data-live-search="true" id="cargo" name="cargo">
                                    <option data-tokens="ketchup mustard" value="{{$funcio->cargo->id}}">{{$funcio->cargo->nome}}</option>
                                    @foreach($cargos as $cargo)
                                        <option data-tokens="ketchup mustard" value="{{$cargo->id}}">{{$cargo->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('cargo'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('cargo') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-8{{ $errors->has('func') ? ' has-error' : '' }}">
                                <label for="func" class="control-label">Nome do Funcionário: </label>

                                <input id="func" type="text" class="form-control" name="func" value="{{ $funcio->nome }}">

                                @if ($errors->has('func'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('func') }}</strong>
                                        </span>
                                @endif

                            </div>

                            <input id="id" type="hidden" name="id" value="{{ $funcio->id }}">

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
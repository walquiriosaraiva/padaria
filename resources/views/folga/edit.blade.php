@extends('home')

@section('titulo','Editar Folga')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Folga</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form"
                              action="{{route('folga.update')}}" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" id="id" name="id" value="{{ $folga->id }}">
                            <div class="form-group col-md-10 {{ $errors->has('func') ? ' has-error' : '' }}">
                                <label for="func" class="control-label">Funcionário:</label>
                                <select class="form-control" data-live-search="true" id="func" name="func">
                                    <option data-tokens="ketchup mustard" value="-1">Selecione</option>
                                    @foreach($funcionarios as $func)
                                        <option data-tokens="ketchup mustard"
                                                value="{{$func->id}}" {{$folga->funcionario_id == $func->id ? 'selected' : ''}}>{{$func->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('func'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('func') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('turno') ? ' has-error' : '' }}">
                                <label for="turno" class="control-label" >Turno:</label>
                                <select class="form-control " data-live-search="true" id="turno" name="turno">
                                    <option data-tokens="ketchup mustard" value="-1">Selecione</option>
                                    <option data-tokens="ketchup mustard" value="0" {{$folga->turno == 'M' ? 'selected' : ''}}>Manhã</option>
                                    <option data-tokens="ketchup mustard" value="1" {{$folga->turno == 'T' ? 'selected' : ''}}>Tarde</option>
                                    <option data-tokens="ketchup mustard" value="2" {{$folga->turno == 'N' ? 'selected' : ''}}>Noite</option>
                                </select>

                                @if ($errors->has('turno'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('turno') }}</strong>
                            </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('data') ? ' has-error' : '' }}">
                                <label for="data" class="control-label">Data: </label>

                                <input id="data" type="date" class="form-control" name="data" value="{{$folga->dia}}">

                                @if ($errors->has('data'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('data') }}</strong>
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
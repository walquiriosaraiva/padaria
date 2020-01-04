@extends('home')

@section('titulo','Cadastrar Usuário')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastrar Usuário</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form"
                              action="{{route('user.store')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group col-md-10{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label"> Nome: </label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label"> E-mail: </label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label"> Senha: </label>
                                <input id="password" type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation" class="control-label"> Repetir Senha: </label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10 {{ $errors->has('tc') ? ' has-error' : '' }}">
                                <label for="perfil" class="control-label">Tipo de Conta:</label>
                                <select class="form-control" data-live-search="true" id="perfil" name="perfil">
                                    <option data-tokens="ketchup mustard" value="">Selecione</option>
                                    <option data-tokens="ketchup mustard" value="1"> Administrador</option>
                                    <option data-tokens="ketchup mustard" value="2"> Gerente</option>
                                    <option data-tokens="ketchup mustard" value="3"> Atendente</option>
                                </select>

                                @if ($errors->has('perfil'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('perfil') }}</strong>
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

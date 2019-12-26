@extends('home')

@section('titulo','Editar Fluxo')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Fluxo</div>
                    <div class="panel-body">
                        <form class="form-horizontal col-md-10 col-md-offset-1" role="form"
                              action="{{route('fluxo.update')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group col-md-6{{ $errors->has('cartao') ? ' has-error' : '' }}">
                                <label for="cartao" class="control-label"> Pagamentos com Cartão: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="cartao" type="text" class="form-control" name="cartao"
                                           value="{{ $fluxo->cartao }} ">
                                </div>
                                @if ($errors->has('cartao'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('cartao') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6 pull-right{{ $errors->has('rd') ? ' has-error' : '' }}">
                                <label for="rd" class="control-label"> Retirada do Dia: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="rd" type="text" class="form-control" name="rd"
                                           value="{{ $fluxo->retirada_dia }}">
                                </div>
                                @if ($errors->has('rd'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('rd') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6{{ $errors->has('rc') ? ' has-error' : '' }}">
                                <label for="rc" class="control-label"> Retirada do Cofre: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="rc" type="text" class="form-control" name="rc"
                                           value="{{ $fluxo->retirada_cofre }}">
                                </div>
                                @if ($errors->has('rc'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('rc') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6 pull-right{{ $errors->has('redi') ? ' has-error' : '' }}">
                                <label for="redi" class="control-label"> Rendimento do Dia: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="redi" type="text" class="form-control" name="redi"
                                           value="{{ $fluxo->rendimento }}">
                                </div>
                                @if ($errors->has('redi'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('redi') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6{{ $errors->has('sd') ? ' has-error' : '' }}">
                                <label for="sd" class="control-label"> Saldo do Dia: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="sd" type="text" class="form-control" name="sd"
                                           value="{{ $fluxo->saldo }}">
                                </div>
                                @if ($errors->has('sd'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('sd') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6 pull-right{{ $errors->has('cf') ? ' has-error' : '' }}">
                                <label for="cf" class="control-label"> Valor no Cofre: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="cf" type="text" class="form-control" name="cf"
                                           value="{{ $fluxo->cofre }}">
                                </div>
                                @if ($errors->has('cf'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('cf') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6{{ $errors->has('td') ? ' has-error' : '' }}">
                                <label for="td" class="control-label"> Total de Vendas: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="td" type="text" class="form-control" name="td"
                                           value="{{ $fluxo->total_vendas }}">
                                </div>
                                @if ($errors->has('td'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('td') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6 pull-right{{ $errors->has('tg') ? ' has-error' : '' }}">
                                <label for="tg" class="control-label"> Total Geral: </label>
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input id="tg" type="text" class="form-control" name="tg"
                                           value="{{ $fluxo->total_geral }}">
                                </div>
                                @if ($errors->has('tg'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('tg') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <input type="hidden" value="{{date('Y-m-d')}}" name="dia">
                            <input type="hidden" value="{{ $fluxo->id }}" name="id" id="id">

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
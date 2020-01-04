@extends('home')

@section('titulo','Saída Estoque')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Saída Estoque</div>
                    <div class="panel-body">
                        <div class="row col-md-10 col-md-offset-1 custyle">

                            @if(session('inser') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    A saída do Produto {{ session("produto") }} foi adicionado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('update') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    A saída do Produto {{ session("produto") }} foi atualizado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('delete') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    A saída do Produto {{ session("produto") }} foi removido.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="panel-body">
                                <form class="form-horizontal col-md-12 col-md-offset-1" role="form"
                                      action="{{route('saida-estoque.show')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group col-md-10{{ $errors->has('produto_id') ? ' has-error' : '' }}">
                                        <label for="produto_id" class="control-label">Produto: </label>
                                        <select class="form-control" data-live-search="true" id="produto_id"
                                                name="produto_id">
                                            <option data-tokens="ketchup mustard" value="">Selecione</option>
                                            @foreach($produto as $key=>$value)
                                                <option data-tokens="ketchup mustard"
                                                        value="{{ $value->id }}" {{ $data['produto_id'] == $value->id ? 'selected' : '' }}> {{ $value->descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-10{{ $errors->has('created_at') ? ' has-error' : '' }}">
                                        <label for="created_at" class="control-label"> Data: </label>
                                        <input id="created_at" type="date" class="form-control" name="created_at"
                                               value="{{ $data['created_at'] }}">
                                    </div>
                                    <div class="form-group col-md-10">
                                        <button type="submit" class="control-label btn btn-primary">Pesquisar</button>
                                    </div>
                                </form>
                            </div>
                            @if($count == 0)
                                <div class="alert alert-danger btn-lg col-md-10 col-md-offset-1 danger">
                                    Você não possui nenhum produto cadastrado.
                                </div>

                                <a href="{{route('saida-estoque.create')}}">
                                    <button type="button"
                                            class="btn btn-primary btn-lg btn-create col-md-3 col-md-offset-4">
                                        <span class="glyphicon glyphicon-plus"></span> Saída Estoque
                                    </button>
                                </a>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped bunitu">
                                        <thead>
                                        <div class="col col-xs-12 text-right">
                                            <a href="{{route('saida-estoque.create')}}">
                                                <button type="button" class="btn btn-sm btn-primary btn-create">
                                                    <span class="glyphicon glyphicon-plus"></span> Saída Estoque
                                                </button>
                                            </a>
                                        </div>
                                        <tr>
                                            <th class="col-lg-3 text-left">Produto</th>
                                            <th class="col-lg-2 text-left">Unidade Medida</th>
                                            <th class="col-lg-2 text-center">Quantidade</th>
                                            <th class="col-lg-2 text-center">Valor Unitário R$</th>
                                            <th class="col-lg-1 text-center">Total R$</th>
                                            <th class="col-lg-2 text-center">Ação</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr class="alert alert-warning">
                                            <th>TOTAL</th>
                                            <th></th>
                                            <th class="text-center">{{ $saidaEstoque->quantidade_total }}</th>
                                            <th></th>
                                            <th class="text-center">{{ $saidaEstoque->soma_total }}</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($saidaEstoque as $estoque)
                                            <tr>
                                                <td class="text-uppercase">{{$estoque->produto}} </td>
                                                <td>{{$estoque->unidade_medida}}</td>
                                                <td class="text-center">{{$estoque->quantidade}} </td>
                                                <td class="text-center">{{$estoque->val_unitario}} </td>
                                                <td class="text-center">{{$estoque->val_total}} </td>
                                                <td class="text-center">
                                                    <a class='btn btn-info btn-xs'
                                                       href="../editar/saida-estoque/{{$estoque->id}}">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>
                                                    <a onclick="return confirm('Deseja excluir esse registro?')"
                                                       href="../deletar/saida-estoque/{{$estoque->id}}"
                                                       class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove"></span> Excluir
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
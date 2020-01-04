@extends('home')

@section('titulo','Controle de Produtos')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Controle de Produtos</div>
                    <div class="panel-body">
                        <div class="row col-md-10 col-md-offset-1 custyle">

                            @if(session('inser') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    O Produto {{ session("produto") }} foi adicionada.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('update') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    O Produto {{ session("produto") }} foi atualizado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('delete') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    O Produto {{ session("produto") }} foi removido.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if($count == 0)
                                <div class="alert alert-danger btn-lg col-md-10 col-md-offset-1 danger">
                                    Você não possui nenhum produto cadastrado.
                                </div>

                                <a href="{{route('produto.create')}}">
                                    <button type="button"
                                            class="btn btn-primary btn-lg btn-create col-md-3 col-md-offset-4">
                                        <span class="glyphicon glyphicon-plus"></span> Produto
                                    </button>
                                </a>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped bunitu">
                                        <thead>
                                        <div class="col col-xs-12 text-right">
                                            <a href="{{route('produto.create')}}">
                                                <button type="button" class="btn btn-sm btn-primary btn-create">
                                                    <span class="glyphicon glyphicon-plus"></span> Produto
                                                </button>
                                            </a>
                                        </div>
                                        <tr>
                                            <th class="col-lg-3 text-left">Descrição</th>
                                            <th class="col-lg-2 text-left">Unidade Medida</th>
                                            <th class="col-lg-2 text-center">Valor Unitário R$</th>
                                            <th class="col-lg-2 text-center">Saldo em Estque</th>
                                            <th class="col-lg-1 text-center">Total R$</th>
                                            <th class="col-lg-2 text-center">Ação</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr class="alert alert-warning">
                                            <th>TOTAL</th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-center">{{ $produtos->quantidade_total }}</th>
                                            <th class="text-center">{{ $produtos->soma_total }}</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($produtos as $produto)
                                            <tr>
                                                <td class="text-uppercase">{{$produto->descricao}} </td>
                                                <td>{{$produto->unidade_medida}}</td>
                                                <td class="text-center alert alert-success">{{$produto->unitario}} </td>
                                                <td class="text-center alert alert-success">{{$produto->saldo_estoque}} </td>
                                                <td class="text-center alert alert-success">{{$produto->total}} </td>
                                                <td class="text-center">
                                                    <a class='btn btn-info btn-xs'
                                                       href="../editar/produto/{{$produto->id}}">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>
                                                    <a onclick="return confirm('Deseja excluir esse registro?')"
                                                       href="../deletar/produto/{{$produto->id}}"
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
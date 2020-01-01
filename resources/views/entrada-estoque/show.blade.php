@extends('home')

@section('titulo','Entrada Estoque')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Entrada Estoque</div>
                    <div class="panel-body">
                        <div class="row col-md-10 col-md-offset-1 custyle">

                            @if(session('inser') == true)
                                <div class="alert alert-success col-md-10 col-md-offset-1">
                                    <strong>Sucesso!</strong>
                                    O Produto {{ session("produto") }} foi adicionada.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('update') == true)
                                <div class="alert alert-success col-md-10 col-md-offset-1">
                                    <strong>Sucesso!</strong>
                                    O Produto {{ session("produto") }} foi atualizado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('delete') == true)
                                <div class="alert alert-success col-md-10 col-md-offset-1">
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

                                <a href="{{route('entrada-estoque.create')}}">
                                    <button type="button"
                                            class="btn btn-primary btn-lg btn-create col-md-3 col-md-offset-4">
                                        <span class="glyphicon glyphicon-plus"></span> Entrada Estoque
                                    </button>
                                </a>
                            @else
                                <table class="table table-striped bunitu">
                                    <thead>
                                    <div class="col col-xs-12 text-right">
                                        <a href="{{route('entrada-estoque.create')}}">
                                            <button type="button" class="btn btn-sm btn-primary btn-create">
                                                <span class="glyphicon glyphicon-plus"></span> Entrada Estoque
                                            </button>
                                        </a>
                                    </div>
                                    <tr>
                                        <th class="text-left">Produto</th>
                                        <th class="text-left">Unidade Medida</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-center">Valor Unitário</th>
                                        <th class="text-center">Valor Total</th>
                                        <th class="col-lg-3 text-center">Ação</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th class="text-center">{{ $entradaEstoque->quantidade_total }}</th>
                                        <th></th>
                                        <th class="text-center">{{ $entradaEstoque->soma_total }}</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($entradaEstoque as $estoque)
                                        <tr>
                                            <td class="text-uppercase">{{$estoque->produto}} </td>
                                            <td>{{$estoque->unidade_medida}}</td>
                                            <td class="text-center">{{$estoque->quantidade}} </td>
                                            <td class="text-center">{{$estoque->val_unitario}} </td>
                                            <td class="text-center">{{$estoque->val_total}} </td>
                                            <td class="text-center">
                                                <a class='btn btn-info btn-xs' href="../editar/entrada-estoque/{{$estoque->id}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a onclick="return confirm('Deseja excluir esse registro?')" href="../deletar/entrada-estoque/{{$estoque->id}}"
                                                   class="btn btn-danger btn-xs">
                                                    <span class="glyphicon glyphicon-remove"></span> Excluir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
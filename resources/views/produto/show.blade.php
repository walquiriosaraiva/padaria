@extends('home')

@section('titulo','Controle de Produtos')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Controle de Produtos</div>
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

                                <a href="{{route('produto.create')}}">
                                    <button type="button"
                                            class="btn btn-primary btn-lg btn-create col-md-3 col-md-offset-4">
                                        <span class="glyphicon glyphicon-plus"></span> Produto
                                    </button>
                                </a>
                            @else
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
                                        <th>Código do Produto</th>
                                        <th>Descrição</th>
                                        <th>Unidade Medida</th>
                                        <th>Quantidade</th>
                                        <th>Valor Unitário</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                    </thead>
                                    @foreach($produtos as $produto)
                                        <tr>
                                            <td>{{$produto->id}}</td>
                                            <td>{{$produto->descricao}} </td>
                                            <td>{{$produto->unidade_medida_id}}</td>
                                            <td>{{$produto->qtd_minimo}} </td>
                                            <td>{{$produto->val_unitario}} </td>
                                            <td class="text-center">
                                                <a class='btn btn-info btn-xs' href="../editar/produto/{{$produto->id}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a onclick="return confirm('Deseja excluir esse registro?')" href="../deletar/produto/{{$produto->id}}"
                                                   class="btn btn-danger btn-xs">
                                                    <span class="glyphicon glyphicon-remove"></span> Excluir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
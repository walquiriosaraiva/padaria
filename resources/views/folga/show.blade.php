@extends('home')

@section('titulo','Controle de Folgas')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Controle de Folgas</div>
                    <div class="panel-body">
                        <div class="row col-md-10 col-md-offset-1 custyle">

                            @if(session('inser') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    A Folga do funcionário {{ session("nome") }} foi adicionada.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('update') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    A Folga do funcionário {{ session("nome") }} foi atualizada.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('delete') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    O Funcionário {{ session('nome') }} foi removido.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if($count == 0)
                                <div class="alert alert-danger btn-lg col-md-10 col-md-offset-1 danger">
                                    Você não possui nenhuma folga cadastrada.
                                </div>

                                <a href="{{route('folga.create')}}">
                                    <button type="button"
                                            class="btn btn-primary btn-lg btn-create col-md-3 col-md-offset-4">
                                        <span class="glyphicon glyphicon-plus"></span> Folga
                                    </button>
                                </a>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped bunitu">
                                        <thead>
                                        <div class="col col-xs-12 text-right">
                                            <a href="{{route('folga.create')}}">
                                                <button type="button" class="btn btn-sm btn-primary btn-create">
                                                    <span class="glyphicon glyphicon-plus"></span> Folga
                                                </button>
                                            </a>
                                        </div>
                                        <tr>
                                            <th>Funcionário</th>
                                            <th>Turno</th>
                                            <th>Data da folga</th>
                                            <th class="text-center">Ação</th>
                                        </tr>
                                        </thead>
                                        @foreach($folgas as $folga)
                                            <tr>
                                                <td>{{$folga->funcionario->nome}}</td>
                                                <td> @if($folga->turno == 'M')
                                                        Manhã
                                                    @elseif($folga->turno == 'N')
                                                        Noite
                                                    @else
                                                        Tarde
                                                    @endif
                                                </td>
                                                <td>{{date_format(new DateTime($folga->dia), "d/m/Y")}} </td>
                                                <td class="text-center">
                                                    <a class='btn btn-info btn-xs'
                                                       href="../editar/folga/{{$folga->id}}">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>
                                                    <a onclick="return confirm('Deseja excluir esse registro?')"
                                                       href="../deletar/folga/{{$folga->id}}"
                                                       class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove"></span> Excluir
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
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
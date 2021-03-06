@extends('home')

@section('titulo','Controle de Boletos')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
                <div class="panel panel-default">
                    <div class="panel-heading">Controle de Boletos</div>
                    <div class="panel-body">
                        <div class="row col-md-12 col-md-offset-0 custyle">

                            @if(session('inser') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    O Boleto N° {{ session("boleto") }} foi adicionado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('update') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    O Boleto N° {{ session("boleto") }} foi atualizado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('delete') == true)
                                <div class="alert alert-success">
                                    <strong>Sucesso!</strong>
                                    O Boleto N° {{ session("boleto") }} foi removido.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if($count == 0)
                                <div class="alert alert-danger btn-lg col-md-10 col-md-offset-1 danger">
                                    Você não possui nenhum Boleto cadastrado.
                                </div>

                                <a href="{{route('boleto.create')}}">
                                    <button type="button"
                                            class="btn btn-primary btn-lg btn-create col-md-3 col-md-offset-4">
                                        <span class="glyphicon glyphicon-plus"></span> Boleto
                                    </button>
                                </a>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped bunitu">
                                        <thead>
                                        <div class="col col-xs-12 text-right">
                                            <a href="{{route('boleto.create')}}">
                                                <button type="button" class="btn btn-sm btn-primary btn-create">
                                                    <span class="glyphicon glyphicon-plus"></span> Boleto
                                                </button>
                                            </a>
                                        </div>
                                        <tr>
                                            <th class="text-center">N° da Nota Fiscal</th>
                                            <th class="text-center">Valor</th>
                                            <th class="text-center">Vencimento</th>
                                            <th class="text-center">Descrição</th>
                                            <th class="text-center">Status do Vencimento</th>
                                            <th class="text-center">Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($boletos as $boleto)
                                            @php($diferenca = strtotime($boleto->pagamento->vencimento) - strtotime(date('Y/m/d', strtotime('+0 days'))) )
                                            @php($dias = floor($diferenca / (60 * 60 * 24)) )

                                            @if($dias >=2 and $dias <=10)
                                                @php($classe = "info")
                                                @php($dias = $dias." dias")
                                            @elseif ($dias == 0)
                                                @php($status = 0)
                                                @php($classe = "danger")
                                                @php($dias = "Hoje")
                                            @elseif($dias < 0)
                                                @php($classe = "warning")
                                                @php($dias = "Já venceu")
                                            @else
                                                @php($classe = "")
                                                @php($dias = $dias." dias")
                                            @endif
                                            <tr class="{{$classe}}">
                                                <td class="text-center">{{$boleto->NF}}</td>
                                                <td class="text-center">{{$boleto->pagamento->valor}}</td>
                                                <td class="text-center">{{date_format(new DateTime($boleto->pagamento->vencimento), "d/m/Y")}}</td>
                                                <td class="text-center">{{$boleto->pagamento->descricao}}</td>
                                                <td class="text-center">{{$dias}}</td>
                                                <td class="text-center">
                                                    <a class='btn btn-info btn-xs'
                                                       href="../editar/boleto/{{$boleto->id}}">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>
                                                    <a onclick="return confirm('Deseja excluir esse registro?')"
                                                       href="../deletar/boleto/{{$boleto->id}}"
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
                            @if(isset($status))
                                <h4>
                                    <span class="alert alert-danger pull-right col-md-6 well-sm text-center">
                                        <span class="glyphicon glyphicon-alert"> Existe boleto que vence hoje </span>
                                    </span>
                                </h4>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

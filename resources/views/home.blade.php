<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('titulo') </title>

    <link rel="stylesheet" type="text/css" href="{{asset('css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/home2.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.modif.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-theme.min.css')}}"/>

    <script scr="{{asset('js/Auxiliar.js')}}"></script>
<!--[if lt IE 9]>
        <script src="{{asset('js/html5shiv.js')}}"></script>
        <script src="{{asset('js/respond.min.js')}}"></script>
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>

        <![endif]-->
</head>

<body>
<div class="container-fluid well-lg">

    @unless (Auth::guest())
        <header class="row container-fluid">
            <nav class="navbar navbar-inversed nav-justified well-sm ">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{route('admin')}}">
                            <img src="/img/nosso-pao.png" class="img-responsive-mod">
                        </a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href={{route('admin')}}> Home </a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false"> Cadastro <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href={{route('boleto.create')}}>Boleto</a></li>
                                <li><a href={{route('cheque.create')}}>Cheque</a></li>
                                <li><a href={{route('conta.create')}}>Conta Corrente</a></li>
                                <li><a href={{route('folga.create')}}>Folga</a></li>
                                <li><a href={{route('fluxo.create')}}>Fluxo-Diário</a></li>
                                <li><a href={{route('funcionario.create')}}>Funcionário</a></li>
                                <li><a href={{route('produto.create')}}>Produto</a></li>
                                <li><a href={{route('entrada-estoque.create')}}>Entrada Estoque</a></li>
                                <li><a href={{route('saida-estoque.create')}}>Saída Estoque</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false"> Controle <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('boleto.show')}}">Boletos</a></li>
                                <li><a href="{{route('cheque.show')}}">Cheques</a></li>
                                <li><a href="{{route('conta.show')}}">Contas</a></li>
                                <li><a href="{{route('fluxo.show')}}">Fluxos-Diários</a></li>
                                <li><a href="{{route('folga.show')}}">Folgas</a></li>
                                <li><a href="{{route('funcionario.show')}}">Funcionários</a></li>
                                <li><a href="{{route('produto.show')}}">Produtos</a></li>
                                <li><a href="{{route('entrada-estoque.show')}}">Entrada Estoque</a></li>
                                <li><a href="{{route('saida-estoque.show')}}">Saída Estoque</a></li>
                            </ul>
                        </li>
                        @if(in_array(Auth::user()->perfil, array(1, 2)))
                            <li><a href="{{route('user.show')}}">Usuários</a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{route('admin.edit')}}"><span
                                        class="glyphicon glyphicon-user"></span> {{Auth::user()->name}} </a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="glyphicon glyphicon-log-in"></span> Sair
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    @endunless

    <div class="row">
        @yield('conteudo')
    </div>

    <footer class="container-fluid welld">
        <div class="container">
            <div class="row col-md-5 pull-left"> &reg; copyright Padaria Nosso Pão 2016-{{date('Y')}}.</div>
        </div>
    </footer>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</div>
</body>
</html>
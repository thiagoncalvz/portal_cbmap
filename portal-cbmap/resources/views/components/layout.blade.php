<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('logomarcacbmap.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{$title}} - Portal CBMAP</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{route('regulamentos.index')}}">
                <img src="{{asset('logocbmap.png')}}" alt="Bootstrap" width="300" height="90">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="https://sistemas.cbm.ap.gov.br/portal">VISTORIA/PROJETO</a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        COMUNIDADE
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Bombeiro Mirim</a></li>
                        <li><a class="dropdown-item" href="#">Concursos</a></li>
                    </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            LEIS E NORMAS
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('regulamentos.index')}}">Leis, Decretos e Portarias</a></li>
                            <li><a class="dropdown-item" href="#">Normas Administrativas</a></li>
                            <li><a class="dropdown-item" href="#">Normas Operacionais</a></li>
                            <li><a class="dropdown-item" href="#">Procedimento Operacional Padrão - POP</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Manuais de Bombeiros</a></li>
                        </ul>
                    </li>
                </ul>
                @if(auth('keycloak')->check())
                    <ul class="navbar-nav navbar-nav-scroll">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth('keycloak')->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">Sair</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav navbar-nav-scroll">
                        <li class="nav-item">
                            <a class="btn btn-outline-secondary" href="{{ route('login') }}">Entrar</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
    <div class="container pb-5 pt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        {{$slot}}
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
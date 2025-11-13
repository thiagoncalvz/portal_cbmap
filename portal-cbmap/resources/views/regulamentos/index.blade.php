<x-layout title="Leis e Normas do CBMAP">
    <x-regulamentos.elements title="Leis e Normas do CBMAP" titleedit=""/>
    @isset($mensagemSucesso)
    <div class="alert alert-success">
        {{$mensagemSucesso}}
    </div>
    @endisset
    <div class="list-group mt-4">
        @foreach ($Regulamentos as $index => $Regulamento)
        <div class="list-group-item list-group-item-action py-3 {{ $index % 2 == 0 ? 'bg-light' : 'bg-white' }}">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h5 class="mb-1">{{$Regulamento->titulo}}</h5>
                <div class="d-flex">
                    <a href="{{route('regulamentos.download', $Regulamento->id)}}" class="btn btn-outline-secondary"><i class="bi bi-download"></i></a>
                     @if(auth('keycloak')->check())
                        <a href="{{route('regulamentos.edit', $Regulamento->id)}}" class="btn btn-outline-secondary ms-2"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{route('regulamentos.destroy', $Regulamento->id)}}" method="post" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-secondary"><i class="bi bi-trash3"></i></button>
                        </form>
                     @endif
                </div>
            </div>
            <p class="mb-1">{{$Regulamento->resumo}}</p>
            <small>{{$Regulamento->obs}}</small>
        </div>
        @endforeach
    </div>
</x-layout>

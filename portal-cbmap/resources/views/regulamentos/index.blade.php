<x-layout title='Regulamentos'>
    <a href="{{route('regulamentos.create')}}" class="btn btn-dark mb-2">Adicionar</a>
    @isset($mensagemSucesso)
    <div class="alert alert-success">
        {{$mensagemSucesso}}
    </div>
    @endisset
    <div class="list-group">
        @foreach ($Regulamentos as $Regulamento)
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h5 class="mb-1">{{$Regulamento->titulo}}</h5>
                <div class="d-flex">
                    <a href="#" class="btn btn-outline-secondary"><i class="bi bi-download"></i></a>
                    <a href="{{route('regulamentos.edit', $Regulamento->id)}}" class="btn btn-outline-secondary ms-2"><i class="bi bi-pencil-square"></i></a>
                    <form action="{{route('regulamentos.destroy', $Regulamento->id)}}" method="post" class="ms-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-secondary"><i class="bi bi-trash3"></i></button>
                    </form>
                </div>
            </div>
            <p class="mb-1">{{$Regulamento->resumo}}</p>
            <small>{{$Regulamento->obs}}</small>
        </div>
        @endforeach
    </div>
</x-layout>

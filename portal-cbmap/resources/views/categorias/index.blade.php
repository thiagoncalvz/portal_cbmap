<x-layout title="Categorias">
    <x-categorias.elements title="Categorias" titleedit=""/>
    @isset($mensagemSucesso)
        <div class="alert alert-success">
            {{$mensagemSucesso}}
        </div>
    @endisset
    @isset($mensagemErro)
        <div class="alert alert-danger">
            {{ $mensagemErro }}
        </div>
    @endisset
    <div class="list-group mt-4">
        @foreach ($Categorias as $index => $Categoria)
        <div class="list-group-item list-group-item-action py-3 {{ $index % 2 == 0 ? 'bg-light' : 'bg-white' }}">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h5 class="mb-1">
                    {{$Categoria->nome}}
                    <span class="badge bg-secondary ms-2">
                        {{ $quantidades[$Categoria->nome] ?? 0 }}
                    </span>
                </h5>
                <div class="d-flex">
                    @if(auth('keycloak')->check())
                        <a href="{{route('categoria.edit', $Categoria->id)}}" class="btn btn-outline-secondary ms-2"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{route('categoria.destroy', $Categoria->id)}}" method="post" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-secondary"><i class="bi bi-trash3"></i></button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-3">
        {{ $Categorias->links() }}
    </div>
</x-layout>

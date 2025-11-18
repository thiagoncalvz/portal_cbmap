    <form action="{{$action}}" method="post" enctype="multipart/form-data" class="mt-4">
        @csrf

        @if($update)
        @method('PUT')
        @endif
        <div class="row mb-3">
            <div class="col-12">
                <label for="nome" class="form-label">Nome da Categoria: *</label>
                <input type="text"
                        autofocus
                        name="nome"
                        id="nome"
                        class="form-control"
                        @isset($nome)value="{{$nome}}"@endisset>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar</button>
        <a href="{{route('categoria.index')}}" class="btn btn-outline-secondary">Voltar</a>
    </form>
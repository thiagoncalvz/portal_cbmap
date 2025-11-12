    <form action="{{$action}}" method="post" enctype="multipart/form-data" class="mt-4">
        @csrf

        @if($update)
        @method('PUT')
        @endif
        <div class="row mb-3">
            <div class="col-12">
                <label for="titulo" class="form-label">Título: *</label>
                <input type="text"
                        autofocus
                        name="titulo"
                        id="titulo"
                        class="form-control"
                        @isset($titulo)value="{{$titulo}}"@endisset>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <label for="resumo" class="form-label">Resumo:</label>
                <input type="text"
                        name="resumo"
                        id="resumo"
                        class="form-control"
                        @isset($resumo)value="{{$resumo}}"@endisset>
            </div>
            <div class="col-4">
                <label for="obs" class="form-label">Obs:</label>
                <input type="text"
                        name="obs"
                        id="obs"
                        class="form-control"
                        @isset($obs)value="{{$obs}}"@endisset>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="documento" class="form-label">Documento (PDF): *</label>
                <input type="file"
                    name="documento"
                    id="documento"
                    class="form-control"
                    accept="application/pdf">
                <div class="form-text">Envie apenas arquivos no formato PDF.</div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar</button>
        <a href="{{route('regulamentos.index')}}" class="btn btn-outline-secondary">Voltar</a>
    </form>
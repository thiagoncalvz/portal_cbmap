<div class="row mt-5">
    <div class="col-6">
        <h3>
            @if(auth('keycloak')->check())
            <a href="{{ route('regulamentos.create') }}" class="btn btn-outline-secondary">
                <i class="bi bi-plus"></i>
            </a>
            @endif
            {{$title}}
            <small class="text-body-secondary">{{$titleedit}}</small>
        </h3>
    </div>
    <div class="col-6">
        <form class="d-flex" role="search" method="GET" action="{{ route('regulamentos.index') }}">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search"/>
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                {{-- <button class="btn btn-outline-secondary" type="submit">Pesquisar</button> --}}
            </div>
        </form>
    </div>
</div>
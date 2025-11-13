<x-layout title="Login" titleedit="">
    {{-- <form action="" method="post">
        @csrf
        <div class="form-group">
            <label for="cpf" class="form-label">CPF</label>
            <input type="number" name="cpf" id="cpf" class="form-control">
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button class="btn btn-primary mt-3">Entrar</button>
    </form> --}}

    <form action="{{ route('sain') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="cpf" class="form-label">CPF</label>
        {{-- <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf') }}"> --}}
        <input type="text" inputmode="numeric" pattern="\d*" name="cpf" id="cpf" class="form-control" />
        @error('cpf') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="password" class="form-label">Senha</label>
        <input type="password" name="password" id="password" class="form-control">
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button class="btn btn-primary mt-3">Entrar</button>
    </form>

</x-layout>
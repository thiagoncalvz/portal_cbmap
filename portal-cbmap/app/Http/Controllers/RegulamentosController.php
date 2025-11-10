<?php

namespace App\Http\Controllers;

use App\Models\Regulamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegulamentosFormRequest;

class RegulamentosController extends Controller{
    public function index(Request $request){
        $regulamento = Regulamentos::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('regulamentos.index')
        ->with('Regulamentos', $regulamento)
        ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create(){
        return view('regulamentos.create');
    }

    public function store(RegulamentosFormRequest $request){
        $regulamento = Regulamentos::create($request->all());

        return to_route('regulamentos.index')
            ->with('mensagem.sucesso', "Regulamento '{$regulamento->titulo}' adicionado com sucesso");
    }

    public function destroy(Regulamentos $regulamento){
        $regulamento->delete();

        return to_route('regulamentos.index')
            ->with('mensagem.sucesso', "Regulamento '{$regulamento->titulo}' removido com sucesso");
    }

    public function edit(Regulamentos $regulamento){
        return view('regulamentos.edit')->with('regulamento', $regulamento);
    }

    public function update(Regulamentos $regulamento, RegulamentosFormRequest $request){
        $regulamento->fill($request->all());
        $regulamento->save();

        return to_route('regulamentos.index')
            ->with('mensagem.sucesso', "Regulamento '{$regulamento->titulo}' atualizada com sucesso");
    }
}

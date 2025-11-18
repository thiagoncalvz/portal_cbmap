<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriasFormRequest;
use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller{
    /**
     * FUNÇÃO PARA CONTAR A QUANTIDADE DE CATEGORIAS
     */
    private function countCategorias(){
        return DB::table('tsilva.regulamentos')
            ->select('categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('categoria')
            ->pluck('total', 'categoria');
    }

    /**
     * FUNÇÃO DA PÁGINA INICIAL DOS REGULAMENTOS
     */
    public function index(Request $request){
        $query = Categorias::query();

        if($request->filled('search')){
            $query->where(function ($q) use ($request){
                $q->where('titulo', 'ILIKE', '%' . $request->search . '%')
                    -> orWhere('resumo', 'ILIKE', '%' . $request->search . '%');
            });
        }

        $categorias = $query
            ->paginate(5)
            ->appends($request->only('search'));
        
        $quantidades = $this->countCategorias();

        $mensagemSucesso = session('mensagem.sucesso');

        return view('categorias.index')
        ->with('Categorias', $categorias)
        ->with('quantidades', $quantidades)
        ->with('mensagemSucesso', $mensagemSucesso);
    }

    /**
     * FUNÇÃO DA PÁGINA DO FORMULÁRIO DE ADD DE REGULAMENTOS
     */
    public function create(){
        return view('categorias.create');
    }

    /**
     * FUNÇÃO DE UPLOAD NO BANCO DE DADOS E NO MINIO
     */
    public function store(CategoriasFormRequest $request, Categorias $categoria){
        // dd($categoria);
        $categoria = DB::transaction(function() use ($request){
            $categoria = Categorias::create($request->all());

            return $categoria;
        });

        return to_route('categoria.index')
            ->with('mensagem.sucesso', "Categorias '{$categoria->nome}' adicionado com sucesso!");
    }

    /**
     * FUNÇÃO DE DELETE DO BANCO DE DADOS E DO MINIO
     */
    public function destroy(Categorias $categoria){
        // dd($Categoria);
        $categoria->delete();

        return to_route('categoria.index')
            ->with('mensagem.sucesso', "Categorias '{$categoria->nome}' removido com sucesso");
    }

    /**
     * FUNÇÃO DA PÁGINA DO FORMULÁRIO DE EDIÇÃO DE REGULAMENTOS
     */
    public function edit(Categorias $categoria){
        return view('categorias.edit')->with('categoria', $categoria);
    }

    /**
     * FUNÇÃO DE UPDATE DO BANCO DE DADOS E DO MINIO
     */
    public function update(Categorias $categoria, CategoriasFormRequest $request){
        $categoria = DB::transaction(function () use ($request, $categoria){
            $categoria->fill($request->all());
            $categoria->save();

            return $categoria;
        });

        return to_route('regulamentos.index')
            ->with('mensagem.sucesso', "Categorias '{$categoria->nome}' atualizada com sucesso");
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegulamentosFormRequest;
use App\Facades\MinIO;
use App\Models\Regulamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;


class RegulamentosController extends Controller{
    /**
     * FUNÇÃO DE UPLOAD DO DOCUMENTO PARA O MINIO
     */
    private function uploadMinioDocument($request, $regulamento){
        if ($request->hasFile('documento') && $request->file('documento')->isValid()) {
            $file = $request->file('documento');
            $bucket = env('MINIO_BUCKET');
            $key = 'regulamentos/' . $regulamento->id . '.pdf';

            $upload = MinIO::upload($bucket, $key, $file->getPathname());
        }
    }

    /**
     * FUNÇÃO DA PÁGINA INICIAL DOS REGULAMENTOS
     */
    public function index(Request $request){
        $regulamento = Regulamentos::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('regulamentos.index')
        ->with('Regulamentos', $regulamento)
        ->with('mensagemSucesso', $mensagemSucesso);
    }

    /**
     * FUNÇÃO DA PÁGINA DO FORMULÁRIO DE ADD DE REGULAMENTOS
     */
    public function create(){
        return view('regulamentos.create');
    }

    /**
     * FUNÇÃO DE UPLOAD NO BANCO DE DADOS E NO MINIO
     */
    public function store(RegulamentosFormRequest $request, Regulamentos $regulamento){
        $regulamento = DB::transaction(function() use ($request){
            $regulamento = Regulamentos::create($request->all());

            $this->uploadMinioDocument($request, $regulamento);

            return $regulamento;
        });

        return to_route('regulamentos.index')
            ->with('mensagem.sucesso', "Regulamento '{$regulamento->titulo}' adicionado com sucesso!");
    }

    /**
     * FUNÇÃO DE DELETE DO BANCO DE DADOS E DO MINIO
     */
    public function destroy(Regulamentos $regulamento){
        if (!empty($regulamento->id)){
            $bucket = env('MINIO_BUCKET');
            $key = 'regulamentos/' . $regulamento->id . '.pdf';

            $delete = MinIO::delete($bucket, $key);
        }
        $regulamento->delete();

        return to_route('regulamentos.index')
            ->with('mensagem.sucesso', "Regulamento '{$regulamento->titulo}' removido com sucesso");
    }

    /**
     * FUNÇÃO DA PÁGINA DO FORMULÁRIO DE EDIÇÃO DE REGULAMENTOS
     */
    public function edit(Regulamentos $regulamento){
        return view('regulamentos.edit')->with('regulamento', $regulamento);
    }

    /**
     * FUNÇÃO DE UPDATE DO BANCO DE DADOS E DO MINIO
     */
    public function update(Regulamentos $regulamento, RegulamentosFormRequest $request){
        $regulamento = DB::transaction(function () use ($request, $regulamento){
            $regulamento->fill($request->all());
            $regulamento->save();

            $this->uploadMinioDocument($request, $regulamento);

            return $regulamento;
        });

        return to_route('regulamentos.index')
            ->with('mensagem.sucesso', "Regulamento '{$regulamento->titulo}' atualizada com sucesso");
    }

    /**
     * FUNÇÃO DE DOWNLOAD DO DOCUMENTO VIA MINIO
     */
    public function DownloadRegulamento(Regulamentos $regulamento){
        $bucket = env('MINIO_BUCKET');
        $key    = 'regulamentos/' . $regulamento->id . '.pdf';

        $result = MinIO::getObject($bucket, $key);

        if (! $result['success']) {
            return back()->with('mensagemErro', 'Erro ao baixar o arquivo: ' . $result['error']);
        }

        $stream   = $result['body']; // PSR-7 StreamInterface
        $filename = $regulamento->id . '.pdf'; // ou monta com o título, se quiser

        return new StreamedResponse(function () use ($stream) {
            // lê o stream e cospe pro output
            echo $stream->getContents();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}

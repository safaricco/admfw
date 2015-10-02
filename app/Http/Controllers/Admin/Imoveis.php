<?php

namespace App\Http\Controllers\Admin;

use App\Models\Imovel;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Imoveis extends Controller
{
    public $tipo_midia = 9;     // CÓDIGO DO TIPO DA MIDIA DA TABELA TIPO_MIDIA

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/imoveis/imoveis', ['imoveis' => Imovel::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/imoveis/store';
        return view('admin/imoveis/dados', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(), [
            'contrato'              => 'required|string',
            'ref'                   => 'required|string|unique:imoveis',
            'titulo'                => 'required|string',
            'descricao'             => 'string',
            'valor'                 => 'required|numeric',
            'rua'                   => 'string',
            'bairro'                => 'required|string',
            'cidade'                => 'string',
            'estado'                => 'string',
            'numero'                => 'string',
            'cep'                   => 'integer',
            'latitude'              => 'string',
            'longitude'             => 'string',
            'dimensoes'             => 'string',
            'area_terreno'          => 'string',
            'area_construida'       => 'string',
            'area_privativa'        => 'string',
            'area_util'             => 'string',
            'andares'               => 'integer',
            'elevadores'            => 'integer',
            'quartos'               => 'integer',
            'suites'                => 'integer',
            'garagem'               => 'integer',
            'banheiros'             => 'integer',
            'detalhes'              => 'string',
            'valor_iptu'            => 'numeric',
            'sala_jantar'           => 'integer',
            'sala_estar'            => 'integer',
            'sala_tv'               => 'integer',
            'cozinha'               => 'integer',
            'area_de_servico'       => 'string',
            'dependencia_empregada' => 'string',
            'gas_central'           => 'string',
            'playground'            => 'string',
            'lavabo'                => 'string',
            'churrasqueira'         => 'string',
            'salao_festas'          => 'string',
            'sacada'                => 'string',
            'portao_eletronico'     => 'string',
            'imagens[]'             => 'image|mimes:jpeg,bmp,png,jpg',
        ]);

        if ($validacao->fails()) :
            return redirect('admin/imoveis/novo')->withErrors($validacao)->withInput();
        else :

            $imovel = new Imovel();

            $imovel->contrato               = $request->contrato;
            $imovel->ref                    = $request->ref;
            $imovel->titulo                 = $request->titulo;
            $imovel->descricao              = $request->descricao;
            $imovel->obs                    = $request->obs;
            $imovel->valor                  = $request->valor;
            $imovel->rua                    = $request->rua;
            $imovel->bairro                 = $request->bairro;
            $imovel->cidade                 = $request->cidade;
            $imovel->estado                 = $request->estado;
            $imovel->numero                 = $request->numero;
            $imovel->cep                    = $request->cep;
            $imovel->latitude               = $request->latitude;
            $imovel->longitude              = $request->longitude;
            $imovel->dimensoes              = $request->dimensoes;
            $imovel->area_terreno           = $request->area_terreno;
            $imovel->area_construida        = $request->area_construida;
            $imovel->area_privativa         = $request->area_privativa;
            $imovel->area_util              = $request->area_util;
            $imovel->andares                = $request->andares;
            $imovel->elevadores             = $request->elevadores;
            $imovel->quartos                = $request->quartos;
            $imovel->suites                 = $request->suites;
            $imovel->garagem                = $request->garagem;
            $imovel->banheiros              = $request->banheiros;
            $imovel->detalhes               = $request->detalhes;
            $imovel->valor_iptu             = $request->valor_iptu;
            $imovel->sala_jantar            = $request->sala_jantar;
            $imovel->sala_estar             = $request->sala_estar;
            $imovel->sala_tv                = $request->sala_tv;
            $imovel->cozinha                = $request->cozinha;
            $imovel->area_de_servico        = $request->area_de_servico;
            $imovel->dependencia_empregada  = $request->dependencia_empregada;
            $imovel->gas_central            = $request->gas_central;
            $imovel->playground             = $request->playground;
            $imovel->lavabo                 = $request->lavabo;
            $imovel->churrasqueira          = $request->churrasqueira;
            $imovel->salao_festas           = $request->salao_festas;
            $imovel->sacada                 = $request->sacada;
            $imovel->portao_eletronico      = $request->portao_eletronico;

            $imovel->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $imovel->id_imovel;
                $midia->descricao           = $nomeTipo . ' criado automaticamente';
                $midia->save();

                foreach ($request->file('imagens') as $img) :

                    $nomeOriginal   = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imagem         = new Multimidia();                                                         // GRAVANDO NA TABELA MULTIMIDIA

                    // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                    $imagem->id_midia   = $midia->id_midia;
                    $imagem->imagem     = $novoNome;
                    $imagem->ordem      = $request->ordem;
                    $imagem->video      = $request->video;

                    $imagem->save();

                endforeach;

            endif;

            session()->flash('flash_message', 'Registro gravado com sucesso!');

            return redirect('admin/imoveis/listar');

        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        $dados['put']       = true;
        $dados['dados']     = Imovel::findOrFail($id);
        $dados['route']     = 'admin/imoveis/atualizar/'.$id;

        return view('admin/imoveis/dados', $dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validacao = Validator::make($request->all(), [
            'contrato'              => 'required|string',
            'ref'                   => 'required|string|unique:imoveis',
            'titulo'                => 'required|string',
            'descricao'             => 'string',
            'valor'                 => 'required|numeric',
            'rua'                   => 'string',
            'bairro'                => 'required|string',
            'cidade'                => 'string',
            'estado'                => 'string',
            'numero'                => 'string',
            'cep'                   => 'integer',
            'latitude'              => 'string',
            'longitude'             => 'string',
            'dimensoes'             => 'string',
            'area_terreno'          => 'string',
            'area_construida'       => 'string',
            'area_privativa'        => 'string',
            'area_util'             => 'string',
            'andares'               => 'integer',
            'elevadores'            => 'integer',
            'quartos'               => 'integer',
            'suites'                => 'integer',
            'garagem'               => 'integer',
            'banheiros'             => 'integer',
            'detalhes'              => 'string',
            'valor_iptu'            => 'numeric',
            'sala_jantar'           => 'integer',
            'sala_estar'            => 'integer',
            'sala_tv'               => 'integer',
            'cozinha'               => 'integer',
            'area_de_servico'       => 'string',
            'dependencia_empregada' => 'string',
            'gas_central'           => 'string',
            'playground'            => 'string',
            'lavabo'                => 'string',
            'churrasqueira'         => 'string',
            'salao_festas'          => 'string',
            'sacada'                => 'string',
            'portao_eletronico'     => 'string',
            'imagens[]'             => 'image|mimes:jpeg,bmp,png,jpg',
        ]);

        if ($validacao->fails()) :
            return redirect('admin/imoveis/editar/' . $id)->withErrors($validacao)->withInput();
        else :

            $imovel = new Imovel();

            $imovel->contrato               = $request->contrato;
            $imovel->ref                    = $request->ref;
            $imovel->titulo                 = $request->titulo;
            $imovel->descricao              = $request->descricao;
            $imovel->obs                    = $request->obs;
            $imovel->valor                  = $request->valor;
            $imovel->rua                    = $request->rua;
            $imovel->bairro                 = $request->bairro;
            $imovel->cidade                 = $request->cidade;
            $imovel->estado                 = $request->estado;
            $imovel->numero                 = $request->numero;
            $imovel->cep                    = $request->cep;
            $imovel->latitude               = $request->latitude;
            $imovel->longitude              = $request->longitude;
            $imovel->dimensoes              = $request->dimensoes;
            $imovel->area_terreno           = $request->area_terreno;
            $imovel->area_util              = $request->area_util;
            $imovel->andares                = $request->andares;
            $imovel->elevadores             = $request->elevadores;
            $imovel->quartos                = $request->quartos;
            $imovel->suites                 = $request->suites;
            $imovel->garagem                = $request->garagem;
            $imovel->banheiros              = $request->banheiros;
            $imovel->valor_iptu             = $request->valor_iptu;
            $imovel->sala_jantar            = $request->sala_jantar;
            $imovel->sala_estar             = $request->sala_estar;
            $imovel->sala_tv                = $request->sala_tv;
            $imovel->area_de_servico        = $request->area_de_servico;
            $imovel->dependencia_empregada  = $request->dependencia_empregada;
            $imovel->gas_central            = $request->gas_central;
            $imovel->playground             = $request->playground;
            $imovel->churrasqueira          = $request->churrasqueira;
            $imovel->salao_festas           = $request->salao_festas;
            $imovel->sacada                 = $request->sacada;
            $imovel->portao_eletronico      = $request->portao_eletronico;

            $imovel->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo   = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                $midia      = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();

                if (count($midia) < 1) :

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $imovel->id_noticia;
                    $midia->descricao           = $nomeTipo . ' criado automaticamente';
                    $midia->save();

                endif;

                foreach ($request->file('imagens') as $img) :

                    $nomeOriginal   = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imagem         = Multimidia::where('id_midia', $midia->id_midia);

                    if (isset($imagem))
                        $imagem = new Multimidia();

                    // GRAVANDO NA TABELA MULTIMIDIA

                    // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                    $imagem->id_midia   = $midia->id_midia;
                    $imagem->imagem     = $novoNome;
                    $imagem->ordem      = $request->ordem;
                    $imagem->video      = $request->video;

                    $imagem->save();

                endforeach;

            endif;

            session()->flash('flash_message', 'Registro gravado com sucesso!');

            return redirect('minhaConta/anuncios/imoveis/listar');

        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Midia::excluir($id);

        Imovel::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/imoveis/listar');
    }

    public function updateStatus($status, $id)
    {
        $dado         = Imovel::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return redirect('admin/imoveis/listar');
    }
}

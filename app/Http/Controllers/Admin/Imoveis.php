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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Imoveis extends Controller
{
    public $tipo_midia      = 9;     // CÓDIGO DO TIPO DA MIDIA DA TABELA TIPO_MIDIA
    public $tipo_categoria  = 4;

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

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $imovel->id_imovel);

            endif;

            session()->flash('flash_message', 'Registro gravado com sucesso!');

            return Redirect::back();

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
        $dados['imagens']   = Midia::imagens($this->tipo_midia, $id);
        $dados['destacada'] = Midia::destacada($this->tipo_midia, $id);
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

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $imovel->id_imovel);

            endif;

            session()->flash('flash_message', 'Registro gravado com sucesso!');

            return Redirect::back();

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
        Midia::excluir($id, $this->tipo_midia);

        Imovel::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Imovel::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}

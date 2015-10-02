@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Imóveis</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Imóveis', 'retorno' => 'imoveis/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Novo Imóvel
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">

                                @if ($put) @include('admin.static.field-put') @endif

                                {!! csrf_field() !!}

                                <div class="form-body">

                                    <div class="form-group">

                                        <div class="col-md-6">
                                            <label>REF:</label>
                                            <input name="ref" type="text" class="form-control" placeholder="REF" value="{{ $dados->ref or old('ref') }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Tipo de Contrato</label>
                                            <select name="idSubcategoria" class="form-control">

                                                @if (!empty($dados))

                                                    @if (($dados->contrato == 'Venda') or ('Venda' == old('contrato')))
                                                        <option  selected value="Venda">Venda</option>
                                                        <option value="Locação">Locação</option>
                                                    @else
                                                        <option value="Venda">Venda</option>
                                                        <option selected value="Locação">Locação</option>
                                                    @endif

                                                @else

                                                    <option value="Venda">Venda</option>
                                                    <option value="Locação">Locação</option>

                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Título</label>
                                            <input name="titulo" type="text" class="form-control" placeholder="Título do imóvel" value="{{ $dados->titulo or old('titulo') }}">
                                        </div>
                                    </div>
     
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Descrição</label>
                                            <textarea name="descricao" id="summernote_1">{{ $dados->descricao or old('descricao') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <label>Rua</label>
                                            <input name="rua" type="text" class="form-control" placeholder="Rua" value="{{ $dados->rua or old('rua') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Número</label>
                                            <input name="numero" type="text" class="form-control" placeholder="Nº" value="{{ $dados->numero or old('numero') }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label>CEP</label>
                                            <input name="cep" type="text" class="form-control" placeholder="CEP" value="{{ $dados->cep or old('cep') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label>Bairro</label>
                                            <input name="bairro" type="text" class="form-control" placeholder="Bairro" value="{{ $dados->bairro or old('bairro') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label>Cidade</label>
                                            <input name="cidade" type="text" class="form-control" placeholder="Cidade" value="{{ $dados->cidade or old('cidade') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label>Estado</label>
                                            <input name="estado" type="text" class="form-control" placeholder="Estado" value="{{ $dados->estado or old('estado') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label>Latitude</label>
                                            <input name="latitude" type="text" class="form-control" placeholder="Latitude" value="{{ $dados->latitude or old('latitude') }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Longitude</label>
                                            <input name="longitude" type="text" class="form-control" placeholder="Longitude" value="{{ $dados->longitude or old('longitude') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label class="control-label">Quantidade dormitórios</label>
                                            <input type="text" class="form-control" placeholder="Dormitórios" value="{{ $dados->quartos or old('quartos') }}" name="quartos" required>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Quantidade suites</label>
                                            <input type="text" class="form-control" placeholder="Suítes" value="{{ $dados->suites or old('suites') }}" name="suites">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Quantidade banheiros</label>
                                            <input type="text" class="form-control" placeholder="Banheiros" value="{{ $dados->banheiros or old('banheiros') }}" name="banheiros" required>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Nº garagem</label>
                                            <input type="text" class="form-control" placeholder="Garagens" value="{{ $dados->garagem or old('garagem') }}" name="garagem">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="col-lg-3">
                                            <label class="control-label">Área útil</label>
                                            <input type="text" class="form-control" placeholder="m²" value="{{ $dados->area_util or old('area_util') }}" name="area_util">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Área total</label>
                                            <input type="text" class="form-control" placeholder="m²" value="{{ $dados->area_terreno or old('area_terreno') }}" name="area_terreno">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Andares</label>
                                            <input type="text" class="form-control" placeholder="Andares" value="{{ $dados->elevadores or old('elevadores') }}" name="elevadores">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Dimenções</label>
                                            <input type="text" class="form-control" placeholder="Dimenções" value="{{ $dados->dimensoes or old('dimensoes') }}" name="dimensoes">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label class="control-label">Valor IPTU</label>
                                            <input type="text" class="form-control" placeholder="Valor IPTU" value="{{ $dados->valor_iptu or old('valor_iptu') }}" name="valor_iptu">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Sala de jantar</label>
                                            <input type="text" class="form-control" placeholder="Sala de jantar" value="{{ $dados->sala_jantar or old('sala_jantar') }}" name="sala_jantar">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Sala de estar</label>
                                            <input type="text" class="form-control" placeholder="Sala de estar" value="{{ $dados->sala_estar or old('sala_estar') }}" name="sala_estar">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="control-label">Sala de TV</label>
                                            <input type="text" class="form-control" placeholder="Sala de TV" value="{{ $dados->sala_tv or old('sala_tv') }}" name="sala_tv">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label class="control-label">Demais Dados</label>

                                            <div class="checkbox-list">

                                                @if ((!empty($dados->playground)) and ($dados->playground == 'Sim' or old('playground')))
                                                    <label><input type="checkbox" name="playground" checked> Playground </label>
                                                @else
                                                    <label><input type="checkbox" name="playground"> Playground </label>
                                                @endif

                                                @if ((!empty($dados->churrasqueira)) and ($dados->churrasqueira == 'Sim' or old('churrasqueira')))
                                                    <label><input type="checkbox" name="churrasqueira" checked> Churrasqueira </label>
                                                @else
                                                    <label><input type="checkbox" name="churrasqueira"> Churrasqueira </label>
                                                @endif

                                                @if ((!empty($dados->gas_central)) and ($dados->gas_central == 'Sim' or old('gas_central')))
                                                    <label><input type="checkbox" name="gas_central" checked> Gás central </label>
                                                @else
                                                    <label><input type="checkbox" name="gas_central"> Gás central </label>
                                                @endif

                                                @if ((!empty($dados->dependencia_empregada)) and ($dados->dependencia_empregada == 'Sim' or old('dependencia_empregada')))
                                                    <label><input type="checkbox" name="dependencia_empregada" checked> Dependência de empregada </label>
                                                @else
                                                    <label><input type="checkbox" name="dependencia_empregada"> Dependência de empregada </label>
                                                @endif

                                                @if ((!empty($dados->area_de_servico)) and ($dados->area_de_servico == 'Sim' or old('area_de_servico')))
                                                    <label><input type="checkbox" name="area_de_servico" checked> Área de serviço </label>
                                                @else
                                                    <label><input type="checkbox" name="area_de_servico"> Área de serviço </label>
                                                @endif

                                                @if ((!empty($dados->salao_festas)) and ($dados->salao_festas == 'Sim' or old('salao_festas')))
                                                    <label><input type="checkbox" name="salao_festas" checked> Salão de festas </label>
                                                @else
                                                    <label><input type="checkbox" name="salao_festas"> Salão de festas </label>
                                                @endif

                                                @if ((!empty($dados->sacada)) and ($dados->sacada == 'Sim' or old('sacada')))
                                                    <label><input type="checkbox" name="sacada" checked> Sacada </label>
                                                @else
                                                    <label><input type="checkbox" name="sacada"> Sacada </label>
                                                @endif

                                                @if ((!empty($dados->portao_eletronico)) and ($dados->portao_eletronico == 'Sim' or old('portao_eletronico')))
                                                    <label><input type="checkbox" name="portao_eletronico" checked> Portão eletrônico </label>
                                                @else
                                                    <label><input type="checkbox" name="portao_eletronico"> Portão eletrônico </label>
                                                @endif
                                            </div>
                                        </div>

                                    </div>





                                    @include('admin.static.field-img-atual', ['tipo' => 'produtos'])

                                    <div class="form-group">
                                        <label class="control-label">Imagens</label>
                                        <input type="file" value="{{ old('imagens[]') }}" name="imagens[]" multiple>
                                    </div>

                                </div>


                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Enviar</button>
                                    <button type="reset" class="btn default">Limpar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
         </div>
    </div>

@stop
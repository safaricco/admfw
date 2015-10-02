@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Configuração Contato </h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Configuração Contato', 'retorno' => 'configuracoes/contato'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Configuração dos meios de contato
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" action="{{ url($route) }}" method="post" >

                                @if ($put) @include('admin.static.field-put') @endif

                                {!! csrf_field() !!}

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Endereço de e-mail</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control input-circle" placeholder="EX: email@safaricomunicacao.com.br" value="{{ $dados->email or old('email') }}" name="email">
                                            <span class="help-block">Este endereço será para qual o formulário de contato do site irá enviar as mensagens de contato</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Telefone</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: 4933280101" value="{{ $dados->telefone or old('telefone') }}" name="telefone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Rua</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: Av. Getúlio Vargas" value="{{ $dados->rua or old('rua') }}" name="rua">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Bairro</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: Centro" value="{{ $dados->bairro or old('bairro') }}" name="bairro">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Cidade</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: Chapecó" value="{{ $dados->cidade or old('cidade') }}" name="cidade">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Estado</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: SC" value="{{ $dados->estado or old('estado') }}" name="estado">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Número</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: 152" value="{{ $dados->numero or old('numero') }}" name="numero">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">CEP</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: 89800000" value="{{ $dados->cep or old('cep') }}" name="cep">
                                            <span class="help-block">Não sabe o seu CEP, <a href="http://www.buscacep.correios.com.br/" target="_blank">clique aqui</a> e descubra!</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Complemento</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: Apto. 202, ED..." value="{{ $dados->complemento or old('complemento') }}" name="complemento">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Latitude</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: -27.1070315" value="{{ $dados->latitude or old('latitude') }}" name="latitude">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Longitude</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: -52.6119455" value="{{ $dados->longitude or old('longitude') }}" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Facebook</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: safaricomunicacaooficial" value="{{ $dados->facebook or old('facebook') }}" name="facebook">
                                            <span class="help-block">Acesse sua página e copie a parte final do endereço no navegador. EX: http://facebook.com/safaricomunicacaooficial. Copie somente a última parte depois da barra "/"</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Google Plus</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: safaricomunicacaooficial" value="{{ $dados->googleplus or old('googleplus') }}" name="googleplus">
                                            {{--<span class="help-block">Acesse sua página e copie a parte final do endereço no navegador. EX: http://facebook.com/safaricomunicacaooficial. Copie somente a última parte depois da barra "/"</span>--}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Twitter</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: safaricomunicacaooficial" value="{{ $dados->twitter or old('twitter') }}" name="twitter">
                                            <span class="help-block">Informe somente a parte @seunome do endereço do twitter</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Instagran</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: safaricomunicacaooficial" value="{{ $dados->instagran or old('instagran') }}" name="instagran">
                                            {{--<span class="help-block">Informe somente a parte @seunome do endereço do twitter</span>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-circle blue">Salvar</button>
                                            <a href="{{ url('admin/dashboard') }}" class="btn btn-circle default">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>

@stop
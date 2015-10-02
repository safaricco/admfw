@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Configuração E-mail </h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Configuração E-mail', 'retorno' => 'configuracoes/email'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Configuração do servidor de e-mails
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" action="{{ url($route) }}" method="post" >

                                @if ($put) @include('admin.static.field-put') @endif

                                {!! csrf_field() !!}

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Protocolo</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: smtp" value="{{ $dados->protocolo or old('protocolo') }}" name="protocolo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Host</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: smtp.safaricomunicacao.com.br" value="{{ $dados->host or old('host') }}" name="host">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Porta</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="EX: 587" value="{{ $dados->porta or old('porta') }}" name="porta">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Endereço de e-mail</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control input-circle" placeholder="EX: noreply@safaricomunicacao.com.br" value="{{ $dados->endereco or old('endereco') }}" name="endereco">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Senha</label>
                                        <div class="col-md-4">
                                            <input type="password" class="form-control input-circle" placeholder="Senha do e-mail" value="{{ old('senha') }}" name="senha">
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
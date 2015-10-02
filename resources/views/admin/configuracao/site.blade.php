@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Configuração Site </h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Configuração Site', 'retorno' => 'configuracoes/site'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Configuração do site
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">

                                @if ($put) @include('admin.static.field-put') @endif

                                {!! csrf_field() !!}

                                <div class="form-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Nome do site</label>
                                                <input name="nome_site" type="text" class="form-control" placeholder="Nome do site" value="{{ $dados->nome_site or old('nome_site') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <label class="control-label">Logo principal</label>
                                                <input type="file" value="{{ old('logo') }}" name="logo">
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                @if(!empty($dados->logo))
                                                    <label class="control-label">Logo principal</label>
                                                    <div class="thumbnail">
                                                        <div class="thumbnail">
                                                            <img src="{{ url('thumb/null/150/logo/' . $dados->logo) }}" class="img-responsive">
                                                        </div>
                                                        <a href="{{ url('uploads/logo/' . $dados->logo) }}" download="{{ url('uploads/logo/' . $dados->logo) }}" class="btn btn-default" role="button" title="Download"><i class="fa fa-download"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <label class="control-label">Logo Rodapé</label>
                                                <input type="file" value="{{ old('logo_footer') }}" name="logo_footer">
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                @if(!empty($dados->logo_footer))
                                                <label class="control-label">Logo Rodapé</label>
                                                <div class="thumbnail">
                                                    <div class="thumbnail">
                                                        <img src="{{ url('thumb/null/100/logo/' . $dados->logo_footer) }}" class="img-responsive">
                                                    </div>
                                                    <a href="{{ url('uploads/logo/' . $dados->logo_footer) }}" download="{{ url('uploads/logo/' . $dados->logo_footer) }}" class="btn btn-default" role="button" title="Download"><i class="fa fa-download"></i></a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
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
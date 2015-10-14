@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Destaques</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Destaques', 'retorno' => 'destaques/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Novo Destaque
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">
                                @if ($put) @include('admin.static.field-put') @endif
                                {!! csrf_field() !!}
                                <div class="form-body">

                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input name="nome" type="text" class="form-control" placeholder="Nome do destaque" value="{{ $dados->nome or old('nome') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Data</label>
                                        <input name="data" type="text" class="form-control" placeholder="Data do destaque" value="{{ $dados->data or old('data') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Hora</label>
                                        <input name="hora" type="text" class="form-control" placeholder="Hora do destaque" value="{{ $dados->hora or old('hora') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Profissional</label>
                                        <input name="profissional" type="text" class="form-control" placeholder="Profissional do destaque" value="{{ $dados->profissional or old('profissional') }}">
                                    </div>

                                    @include('admin.static.field-img-atual', ['tipo' => 'destaques'])

                                    <div class="form-group">
                                        <label class="control-label">Imagens</label>
                                        <input type="file" value="{{ old('imagem') }}" name="imagem">
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
@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Depoimentos</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Depoimentos', 'retorno' => 'depoimentos/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Novo Depoimento
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post">
                                @if ($put) @include('admin.static.field-put') @endif
                                {!! csrf_field() !!}
                                <div class="form-body">

                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input name="nome" type="text" class="form-control" placeholder="Nome do depoente" value="{{ $dados->nome or old('nome') }}">
                                    </div>
     
                                    <div class="form-group">
                                        <label>Texto</label>
                                        <textarea name="texto" id="summernote_1">{{ $dados->texto or old('texto') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Codigo Vídeo</label>
                                        <input name="video" type="text" class="form-control" placeholder="Código do vídeo" value="{{ $dados->video or old('video') }}">
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
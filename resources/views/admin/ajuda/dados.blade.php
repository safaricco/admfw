@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">

            @include('admin.static.modal-icons')

            <div class="page-head">
                <div class="page-title">
                    <h1>Ajuda</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Ajuda', 'retorno' => 'ajuda/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Novo item de ajuda
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">
                                @if ($put) @include('admin.static.field-put') @endif
                                {!! csrf_field() !!}
                                <div class="form-body">


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <label> Título do Item de ajuda </label>
                                                <input name="titulo" type="text" class="form-control" placeholder="Título da Notícia" value="{{ $dados->titulo or old('titulo') }}">
                                                <span class="help-block">Este título será o nome do item que será exibido no menu do usuário</span>
                                            </div>
                                            <div class="col-lg-4">
                                                <label> Icone </label>
                                                <input name="icone" type="text" class="form-control" placeholder="Título da Notícia" value="{{ $dados->icone or old('icone') }}">
                                                <span class="help-block">Encontre o icone igual ao do menu <a href="#modal-icones" data-toggle="modal">aqui</a> </span>
                                            </div>
                                        </div>

                                    </div>
     
                                    <div class="form-group">
                                        <label> Texto </label>
                                        <textarea name="texto" id="summernote_1">{{ $dados->texto or old('texto') }}</textarea>
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
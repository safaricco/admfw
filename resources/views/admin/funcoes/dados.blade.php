@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Módulos </h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Módulos', 'retorno' => 'configuracoes/modulos/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Novo Módulo
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" >

                                @if ($put) @include('admin.static.field-put') @endif

                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input name="nome" type="text" class="form-control" placeholder="Nome do módulo" value="{{ $dados->nome or old('nome') }}">
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
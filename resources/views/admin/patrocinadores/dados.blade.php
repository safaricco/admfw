@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Patrocinadores</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Patrocinadores', 'retorno' => 'patrocinadores/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Novo Patrocinador
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">
                                @if ($put) @include('admin.static.field-put') @endif
                                {!! csrf_field() !!}
                                <div class="form-body">


                                    <div class="form-group">
                                        <label>Título Patrocinador</label>
                                        <div class="input-icon">
                                            <i class="fa fa-bell-o"></i>
                                            <input name="titulo" type="text" class="form-control" placeholder="Título Patrocinador" value="{{ $dados->titulo or old('titulo') }}">
                                        </div>
                                    </div>
     
                                    <div class="form-group">
                                        <label>Texto Patrocinador</label>
                                        <textarea name="texto" class="form-control" rows="3">{{ $dados->texto or old('texto') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <div class="input-icon">
                                            <i class="fa fa-bell-o"></i>
                                            <input name="endereco" type="text" class="form-control" placeholder="Endereço" value="{{ $dados->endereco or old('endereco') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <div class="input-icon">
                                            <i class="fa fa-bell-o"></i>
                                            <input name="telefone" type="text" class="form-control" placeholder="telefone" value="{{ $dados->telefone or old('telefone') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Link</label>
                                        <div class="input-icon">
                                            <i class="fa fa-bell-o"></i>
                                            <input name="link" type="text" class="form-control" placeholder="link" value="{{ $dados->link or old('link') }}">
                                        </div>
                                    </div>

                                    @include('admin.static.field-img-atual', ['tipo' => 'patrocinadores'])

                                    <div class="form-group">
                                        <label class="control-label">Imagens</label>
                                        <input type="file" class="form-control" value="{{ old('imagens[]') }}" name="imagens[]" multiple>
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
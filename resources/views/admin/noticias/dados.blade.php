@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Notícias</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Notícias', 'retorno' => 'noticias/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Nova Notícia
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">
                                @if ($put) @include('admin.static.field-put') @endif
                                {!! csrf_field() !!}
                                <div class="form-body">

                                    <div class="form-group">
                                        <label>Subcategoria</label>
                                        <select name="id_subcategoria" class="form-control">

                                        @foreach($subcategorias as $sub)

                                            @if (!empty($dados))

                                                @if (($sub->id_subcategoria == $dados->id_subcategoria) or ($sub->id_subcategoria == old('id_subcategoria')))

                                                    <option selected value="{{ $sub->id_subcategoria }}">{{ $sub->titulo }}</option>

                                                @else

                                                    <option value="{{ $sub->id_subcategoria }}">{{ $sub->titulo }}</option>

                                                @endif

                                            @else

                                                <option value="{{ $sub->id_subcategoria }}">{{ $sub->titulo }}</option>

                                            @endif

                                        @endforeach


                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label> Título Notícia </label>
                                        <input name="titulo" type="text" class="form-control" placeholder="Título da Notícia" value="{{ $dados->titulo or old('titulo') }}">
                                    </div>

                                    <div class="form-group">
                                        <label> Resumo Notícia </label>
                                        <input name="resumo" type="text" class="form-control" placeholder="Resumo da Notícia" value="{{ $dados->resumo or old('resumo') }}">
                                    </div>
     
                                    <div class="form-group">
                                        <label> Texto Notícia </label>
                                        <textarea name="texto" id="summernote_1">{{ $dados->texto or old('texto') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label> Destaque </label>
                                        <select name="destaque" class="form-control">
                                            @if (!empty($dados->destaque))
                                                @if($dados->destaque == 'não')

                                                    <option selected value="não"> Nâo </option>
                                                    <option value="sim"> Sim </option>

                                                @elseif($dados->destaque == 'sim')
                                                    <option value="não"> Nâo </option>
                                                    <option selected value="sim"> Sim </option>
                                                @endif

                                            @else
                                                <option value="não"> Não </option>
                                                <option value="sim"> Sim </option>
                                            @endif
                                        </select>
                                    </div>

                                    @if(!empty($midia))
                                        <div class="form-group">
                                            <label class="control-label">Imagens atuais:</label>
                                            <div class="row">
                                                <div class="col-xs-6 col-md-3">
                                                    <div class="thumbnail">
                                                        <div class="thumbnail">
                                                            <img src="{{ url('thumb/348/null/noticias/' . $midia->imagem_destacada) }}" class="img-responsive">
                                                        </div>
                                                        <a data-rel="fancybox-button" href="{{ url('uploads/noticias/' . $midia->imagem_destacada) }}" class="btn btn-primary fancybox-button" role="button" title="Visualizar"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ url('uploads/noticias/' . $midia->imagem_destacada) }}" download="{{ url('uploads/noticias/' . $midia->imagem_destacada) }}" class="btn btn-default" role="button" title="Download"><i class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label class="control-label">Imagem destacada</label>
                                        <input type="file" value="{{ old('imagem') }}" name="imagem">
                                    </div>

                                    @include('admin.static.field-img-atual', ['tipo' => 'noticias'])

                                    <div class="form-group">
                                        <label class="control-label">Galeria</label>
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
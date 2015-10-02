@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Categorias </h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Categorias', 'retorno' => 'categorias/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Nova Categoria
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" >

                                @if ($put) @include('admin.static.field-put') @endif

                                {!! csrf_field() !!}
                                <div class="form-body">

                                    <div class="form-group">
                                        <label>Tipo da categoria</label>
                                        <select name="tipo_categoria" id="tipo_categoria" class="form-control">

                                            @foreach($tipos as $tipo)

                                                @if(!empty($dados))

                                                    @if($dados->id_tipo_categoria == $tipo->id_tipo_categoria || $dados->id_tipo_categoria == old('id_categoria'))

                                                        <option selected value="{{ $tipo->id_tipo_categoria }}">{{ $tipo->titulo }}</option>

                                                    @else

                                                        <option value="{{ $tipo->id_tipo_categoria }}">{{ $tipo->titulo }}</option>

                                                    @endif

                                                @else

                                                    <option value="{{ $tipo->id_tipo_categoria }}">{{ $tipo->titulo }}</option>

                                                @endif

                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Título Categoria</label>
                                        <input name="titulo" type="text" class="form-control" placeholder="Título Categoria" value="{{ $dados->titulo or old('titulo') }}">
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
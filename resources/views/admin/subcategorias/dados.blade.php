@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Subcategorias</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Subcategorias', 'retorno' => 'subcategorias/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Nova Subcategoria
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">
                                @if ($put) @include('admin.static.field-put') @endif
                                {!! csrf_field() !!}
                                <div class="form-body">

                                    <div class="form-group">
                                        <label>Categoria Pai</label>
                                        <select name="id_categoria" class="form-control">


                                            @foreach($categorias as $categoria)

                                                @if (!empty($dados))

                                                    @if (($categoria->id_categoria == $dados->id_categoria) or ($categoria->id_categoria == old('idCategoria')))
                                                        <option selected value="{{ $categoria->id_categoria }}">{{ $categoria->titulo }}</option>
                                                    @else
                                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->titulo }}</option>
                                                    @endif

                                                @else

                                                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->titulo }}</option>

                                                @endif

                                            @endforeach


                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Título Subcategoria</label>
                                        <input name="titulo" type="text" class="form-control" placeholder="Título Sub Categoria" value="{{ $dados->titulo or old('titulo') }}">
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
@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Perfis</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Perfis', 'retorno' => 'configuracoes/perfis/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Novo perfil de usuário
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" enctype="multipart/form-data">
                                @if ($put) @include('admin.static.field-put') @endif
                                {!! csrf_field() !!}
                                <div class="form-body">

                                    <div class="form-group">
                                        <label>Nome do perfil</label>
                                        <input name="descricao" type="text" class="form-control" placeholder="Nome do perfil" value="{{ $dados->descricao or old('descricao') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Permissões</label>

                                        <dl class="dl-horizontal">
                                            <?php $cont = 1 ?>
                                            @foreach($funcoes as $funcao)

                                                <dt>{{ $funcao->nome }} <a class="popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ $funcao->descricao }}" data-original-title="Descriçao da permissão {{ $funcao->nome }}"><i class="fa fa-question-circle"></i></a></dt>
                                                <dd>

                                                    <div class="radio-list">
                                                        @if(!empty($permissao))
                                                            @foreach($permissao as $perm)
                                                                @foreach($roles as $role)

                                                                    {{--@if($role->descricao != 'Perfil' and empty($permissao))--}}

                                                                        {{--@if(($role->descricao == 'Permitir' and empty($dados)) or $role->id_role == old($funcao->id_funcao))--}}
            {{--                                                        @if ((!empty($dados->playground)) and ($dados->playground == 'Sim' or old('playground')))--}}
                                                                            {{--<label class="radio-inline"><input type="radio" checked name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>--}}
                                                                        {{--@else--}}
                                                                            {{--<label class="radio-inline"><input type="radio" name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>--}}

                                                                        {{--@endif--}}

                                                                    {{--@else--}}
                                                                        @if($role->descricao != 'Perfil')

                                                                        @if ($funcao->id_funcao == $perm->id_funcao)

                                                                            @if($perm->id_role == $role->id_role or $role->id_role == old($funcao->id_funcao))
        {{--                                                                @if ((!empty($dados->playground)) and ($dados->playground == 'Sim' or old('playground')))--}}
                                                                                <label class="radio-inline"><input type="radio" checked name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>
                                                                            @else
                                                                                <label class="radio-inline"><input type="radio" name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>

                                                                            @endif
                                                                        @endif

                                                                    @endif

                                                                @endforeach
                                                            @endforeach

                                                        @else

                                                            @foreach($roles as $role)

                                                            @if($role->descricao != 'Perfil' and empty($permissao))

                                                                @if(($role->descricao == 'Permitir' and empty($dados)) or $role->id_role == old($funcao->id_funcao))
                                                                    {{--                                                        @if ((!empty($dados->playground)) and ($dados->playground == 'Sim' or old('playground')))--}}
                                                                    <label class="radio-inline"><input type="radio" checked name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>
                                                                @else
                                                                    <label class="radio-inline"><input type="radio" name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>

                                                                @endif

                                                            @endif

                                                        @endforeach

                                                        @endif
                                                    </div>
                                                </dd>

                                                <?php $cont = $cont + 1 ?>

                                            @endforeach

                                        </dl>
                                    </div>



                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Enviar</button>
                                    <a href="{{ url('admin/configuracoes/perfis/listar') }}" class="btn default">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
         </div>
    </div>

@stop
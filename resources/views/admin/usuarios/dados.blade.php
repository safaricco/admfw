@extends('admin.static.site')

@section('title', 'Usuários')

    @section('content')

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-head">
                    <div class="page-title">
                        <h1>Usuário</h1>
                    </div>
                </div>
                @include('admin.static.breadcrumb', ['active' => 'Usuário', 'retorno' => 'configuracoes/usuarios/listar'])

                <div class="row">

                    <div class="col-md-12 ">
                        @include('admin.static.mensagem')

                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>Cadastro de usuários
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form method="post" action="{{ url($route) }}">
                                    @if ($put) @include('admin.static.field-put') @endif
                                    {!! csrf_field() !!}

                                    <div class="form-body">

                                        <div class="form-group">
                                            <label class="control-label">Perfil</label>
                                            <select name="id_perfil" id="id_perfil" class="form-control">

                                                @foreach($perfis as $perfil)

                                                    @if (!empty($perfilUser))

                                                        @if (($perfilUser->id_perfil == $perfil->id_perfil) or ($perfil->id_perfil == old('id_perfil')))

                                                            <option selected value="{{ $perfil->id_perfil }}">{{ $perfil->descricao }}</option>

                                                        @else

                                                            <option value="{{ $perfil->id_perfil }}">{{ $perfil->descricao }}</option>

                                                        @endif

                                                    @else

                                                        <option value="{{ $perfil->id_perfil }}">{{ $perfil->descricao }}</option>

                                                    @endif

                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Nome</label>
                                            <input type="text" class="form-control" placeholder="Nome do usuário" value="{{ $dados->name or old('name') }}" name="name" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">E-mail</label>
                                            <input type="email" class="form-control" placeholder="E-mail" value="{{ $dados->email or old('email') }}" name="email" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Senha</label>
                                            <input type="password" class="form-control" placeholder="Senha" name="password" value="{{ old('password') }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Permissões especificas a este usuário</label>

                                            <dl class="dl-horizontal">
                                                <?php $cont = 1 ?>
                                                @foreach($funcoes as $funcao)

                                                    <dt>{{ $funcao->nome }} <a class="popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ $funcao->descricao }}" data-original-title="Descriçao da permissão {{ $funcao->nome }}"><i class="fa fa-question-circle"></i></a></dt>
                                                    <dd>

                                                        <div class="radio-list">
                                                            @if(!empty($permissao))
                                                                @foreach($permissao as $perm)
                                                                    @foreach($roles as $role)

                                                                        @if ($funcao->id_funcao == $perm->id_funcao)

                                                                            @if($perm->id_role == $role->id_role or $role->id_role == old($funcao->id_funcao))
                                                                                {{--@if ((!empty($dados->playground)) and ($dados->playground == 'Sim' or old('playground')))--}}
                                                                                <label class="radio-inline"><input type="radio" checked name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>
                                                                            @else
                                                                                <label class="radio-inline"><input type="radio" name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>

                                                                            @endif
                                                                        @endif

                                                                    @endforeach
                                                                @endforeach

                                                            @else

                                                                @foreach($roles as $role)

                                                                    @if(($role->descricao == 'Perfil' and empty($dados)) or $role->id_role == old($funcao->id_funcao))
                                                                        {{--@if ((!empty($dados->playground)) and ($dados->playground == 'Sim' or old('playground')))--}}
                                                                        <label class="radio-inline"><input type="radio" checked name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>
                                                                    @else
                                                                        <label class="radio-inline"><input type="radio" name="{{ $funcao->id_funcao }}" value="{{ $role->id_role }}"> {{ $role->descricao }} </label>

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
                                        <button type="submit" class="btn green">Salvar</button>
                                        <a href="{{ url('admin/configuracoes/usuarios/listar') }}" class="btn default">Cancelar</a>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
                </div>
            </div>
        </div>

    @endsection
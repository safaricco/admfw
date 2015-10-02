@extends('admin.static.site')

@section('title', 'Perfil')

@section('content')

        <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Meu Perfil</h1>
            </div>
        </div>
        @include('admin.static.breadcrumb', ['active' => 'Meu Perfil', 'retorno' => 'configuracoes/perfis/listar'])

        <div class="row">

            <div class="col-md-12 ">
                @include('admin.static.mensagem')

                        <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar" style="width:250px;">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            <img src="{{ url('assets/admin/admin/pages/media/sem-imagem.png') }}" class="img-responsive" alt=""/>
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active">
                                    <a href="{{ url('admin/configuracoes/usuarios/perfil/editar/' . Auth::user()->id) }}">
                                        <i class="icon-home"></i>
                                        Dados </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                    <!-- END PORTLET MAIN -->

                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Perfil do Usuário</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">Dados Pessoais</a>
                                        </li>

                                        <li>
                                            <a href="#tab_1_3" data-toggle="tab">Credenciais</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
                                            <form role="form" action="{{ url('admin/configuracoes/usuarios/perfil/dados/' . $user->id) }}" method="post">
                                                {!! csrf_field() !!}

                                                <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12  ">
                                                    <div class="form-group">
                                                        <label class="control-label"> Nome: </label>
                                                        <input name="name" placeholder="Nome " class="form-control" type="text" value="{{ $user->name or old('name') }}" required/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12 ">
                                                    <div class="form-group">
                                                        <label class="control-label"> Email: </label>
                                                        <input name="email" placeholder="Email" class="form-control" type="email" value="{{ $user->email or old('email') }}" disabled/>
                                                    </div>
                                                </div>
                                                <div class="margiv-top-10">
                                                    <button type="submit" class="btn green-haze">Salvar </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                        <!-- CHANGE PASSWORD TAB -->
                                        <div class="tab-pane" id="tab_1_3">
                                            <form role="form" action="{{ url('admin/configuracoes/usuarios/perfil/senha/' . $user->id) }}" method="post">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <label class="control-label">Senha Atual</label>
                                                    <input type="password" class="form-control" name="senhaAtual"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Nova Senha</label>
                                                    <input type="password" class="form-control" name="password"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Repetir Nova Senha</label>
                                                    <input type="password" class="form-control" name="password_confirmation"/>
                                                </div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green-haze">Salvar </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END CHANGE PASSWORD TAB -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
    </div>
</div>

@endsection
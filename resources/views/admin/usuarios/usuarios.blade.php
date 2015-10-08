@extends('admin.static.site')

@section('title', 'Usuários')

    @section('content')

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-head">
                    <div class="page-title">
                        <h1>Usuários</h1>
                    </div>
                </div>
                @include('admin.static.breadcrumb', ['active' => 'Usuários', 'retorno' => 'configuracoes/usuarios/listar'])
                <div class="row">

                    <div class="col-md-12 ">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Usuários
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th>Cód.</th>
                                        <th>Usuário</th>
                                        <th>Perfil</th>
                                        <th>E-mail</th>
                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($usuarios as $user)

                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->perfil }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="{{ url('/admin/configuracoes/usuarios/editar/' . $user->id) }}" class="btn btn-icon-only yellow" title="Editar"><i class="fa fa-edit"></i></a>
                                                @if ($user->id <> Auth::user()->id)

                                                    @if ($user->status == 1)
                                                        <a href="{{ url('/admin/configuracoes/usuarios/status/0/' . $user->id) }}" class="btn btn-icon-only green" title="Ativo"><i class="fa fa-thumbs-o-up"></i></a>
                                                    @else
                                                        <a href="{{ url('/admin/configuracoes/usuarios/status/1/' . $user->id) }}" class="btn btn-icon-only grey-cascade" title="Inativo"><i class="fa fa-thumbs-o-down"></i></a>
                                                    @endif

                                                @endif
                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
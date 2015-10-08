{{--<ul class="page-breadcrumb breadcrumb">--}}
    {{--<li>--}}
        {{--<a href="{{ url('admin/dashboard') }}">Home</a>--}}
    {{--</li>--}}
    {{--<li class="active">--}}
        {{--<a href="{{ url('admin/' . $retorno) }}">{{ $active }}</a>--}}
    {{--</li>--}}
{{--</ul>--}}

<!-- subheader begin -->
<div id="subheader">
    <div class="container">
        <div class="row">
            <div class="span12">
                <h1>{{ $titulo }}</h1>
                <span>{{ $mensagem }}</span>
                <ul class="crumb">
                    <li><a href="{{ url() }}">Home</a></li>
                    <li class="sep">/</li>
                    <li>{{ $paginabc }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- subheader close -->
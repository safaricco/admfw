<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{ url('admin/dashboard') }}">Home</a>
    </li>
    <li class="active">
        <a href="{{ url('admin/' . $retorno) }}">{{ $active }}</a>
    </li>
</ul>
<div id="sidebar" class="span3">

    <div class="widget tab-holder">
        <div class="de_tab">
            <ul class="de_nav">
                <li><span class="active">Últimas Postagens</span></li>
            </ul>

            <div class="de_tab_content">

                <div class="tab-small-post">
                    <ul>
                        @if(!empty($ultimas))
                            @foreach($ultimas as $ultima)
                                <li>
                                    <img src="{{ url('thumb/52/52/noticias/'.$ultima->imagem_destacada) }}" class="post-info" alt="" />
                                    <span class="post-content">
                                        <a href="{{ url('blog/' . $ultima->slug . '/' . $ultima->id_noticia) }}">{{ $ultima->titulo }}</a></span>
                                    <span class="post-date">{{ $ultima->data }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

            </div>

        </div>
    </div>
    <div class="widget widget_category">
        <h4>Categorias</h4>
        <ul>
            @if(!empty($categorias))
                @foreach($categorias as $categoria)
                    <li><a href="{{ url('blog/categoria/'.$categoria->id_categoria) }}">{{ $categoria->titulo }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
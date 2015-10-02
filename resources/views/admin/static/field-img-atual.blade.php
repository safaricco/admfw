@if (!empty($imagens))
    <div class="form-group">
        <label class="control-label">Imagens atuais:</label>
        <div class="row">

            {{--@if(count($imagens) > 1)--}}

                @foreach($imagens as $img)

                    <div class="col-xs-6 col-md-3" id="image{{ $img->id_multimidia }}">
                        <div class="thumbnail">
                            <div class="thumbnail">
    {{--                                <img src="{{ url('uploads/' . $tipo . '/' . $img->imagem) }}" class="img-responsive">--}}
                                <img src="{{ url('thumb/348/null/' . $tipo . '/' . $img->imagem) }}" class="img-responsive">
                            </div>
                            <a data-rel="fancybox-button" href="{{ url('uploads/' . $tipo . '/' . $img->imagem) }}" class="btn btn-primary fancybox-button" role="button" title="Visualizar"><i class="fa fa-eye"></i></a>
                            <button type="button" value="{{ $img->id_multimidia }}" data-url="/admin/multimidia/destroyFoto" class="btn btn-success deletefoto" role="button" title="Excluir"><i class="fa fa-remove"></i></button>
                            <a href="{{ url('uploads/' . $tipo . '/' . $img->imagem) }}" download="{{ url('uploads/' . $tipo . '/' . $img->imagem) }}" class="btn btn-default" role="button" title="Download"><i class="fa fa-download"></i></a>
                        </div>
                    </div>

                @endforeach

            {{--@else--}}

                {{--<div class="col-xs-6 col-md-3" id="image{{ $imagens->id_multimidia }}">--}}
                    {{--<div class="thumbnail">--}}
                        {{--<div class="thumbnail">--}}
{{--                                <img src="{{ url('uploads/' . $tipo . '/' . $img->imagem) }}" class="img-responsive">--}}
                            {{--<img src="{{ url('thumb/348/null/' . $tipo . '/' . $imagens->imagem) }}" class="img-responsive">--}}
                        {{--</div>--}}
                        {{--<a data-rel="fancybox-button" href="{{ url('uploads/' . $tipo . '/' . $imagens->imagem) }}" class="btn btn-primary fancybox-button" role="button" title="Visualizar"><i class="fa fa-eye"></i></a>--}}
                        {{--<button type="button" value="{{ $imagens->id_multimidia }}" data-url="/admin/multimidia/destroyFoto" class="btn btn-success deletefoto" role="button" title="Excluir"><i class="fa fa-remove"></i></button>--}}
                        {{--<a href="{{ url('uploads/' . $tipo . '/' . $imagens->imagem) }}" download="{{ url('uploads/' . $tipo . '/' . $imagens->imagem) }}" class="btn btn-default" role="button" title="Download"><i class="fa fa-download"></i></a>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--@endif--}}

        </div>

    </div>

@endif

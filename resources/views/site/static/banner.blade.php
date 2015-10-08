<!-- slider -->
<div class="fullwidthbanner-container visible-desktop">
    <div id="revolution-slider">
        <ul>
            @foreach($banners as $banner)

                <li data-transition="fade" data-slotamount="10" data-masterspeed="300" data-thumb="{{ asset('uploads/banners/'. $banner->imagem) }}">
                    <img src="{{ asset('uploads/banners/'. $banner->imagem) }}" alt="" />
                </li>

            @endforeach

        </ul>
    </div>
</div>
<!-- slider close -->
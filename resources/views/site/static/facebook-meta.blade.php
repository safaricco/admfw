@if (!empty($meta_title))
    <meta property="og:title" content="{{ $meta_title }}" />
@else
    <meta property="og:title" content="" />
@endif

@if (!empty($meta_image))
    <meta property="og:image" content="{{ $meta_image }}" />
@else
    <meta property="og:image" content="" />
@endif

<meta property="og:url" content="" />

@if (!empty($meta_description))
    <meta property="og:description" content="{{ $meta_description }}" />
@else
    <meta property="og:description" content="" />
@endif

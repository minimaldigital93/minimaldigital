@php
    $metaTitle = trim($__env->yieldContent('seo_title')) ?: setting('seo_title', setting('company_name', 'MinimalDigital'));
    $metaDescription = trim($__env->yieldContent('seo_description')) ?: setting('seo_description', '');
    $metaKeywords = trim($__env->yieldContent('seo_keywords')) ?: setting('seo_keywords', '');
    $metaImage = trim($__env->yieldContent('seo_image')) ?: url(media_url(setting('logo', '/images/brand/logo.svg')));
    $canonical = url()->current();
@endphp

<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
@if($metaKeywords)<meta name="keywords" content="{{ $metaKeywords }}">@endif
<link rel="canonical" href="{{ $canonical }}">

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ setting('company_name', 'MinimalDigital') }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $metaImage }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $metaImage }}">

{{-- Schema.org --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => setting('company_name', 'MinimalDigital'),
    'url' => url('/'),
    'logo' => url(media_url(setting('logo', '/images/brand/logo.svg'))),
    'email' => setting('email'),
    'sameAs' => array_values(array_filter([
        setting('facebook'), setting('telegram'), setting('github'),
        setting('linkedin'), setting('youtube'), setting('instagram'),
    ])),
], JSON_UNESCAPED_SLASHES) !!}
</script>

@yield('structured_data')

@php
    $tags = $seo->generateTags();
    $hreflangs = $seo->getHreflangs();
@endphp

<!-- Primary Meta Tags -->
<title>{{ $tags['title'] }}</title>
<meta name="title" content="{{ $tags['title'] }}">
<meta name="description" content="{{ $tags['description'] }}">

<!-- Canonical Link -->
<link rel="canonical" href="{{ $tags['canonical'] }}">

<!-- Internationalization (Hreflang) -->
@foreach($hreflangs as $locale => $url)
<link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ $hreflangs['en'] ?? url('/') }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $tags['og_type'] }}">
<meta property="og:url" content="{{ $tags['og_url'] }}">
<meta property="og:title" content="{{ $tags['og_title'] }}">
<meta property="og:description" content="{{ $tags['og_description'] }}">
<meta property="og:image" content="{{ $tags['og_image'] }}">

<!-- Twitter -->
<meta property="twitter:card" content="{{ $tags['twitter_card'] }}">
<meta property="twitter:url" content="{{ $tags['og_url'] }}">
<meta property="twitter:title" content="{{ $tags['og_title'] }}">
<meta property="twitter:description" content="{{ $tags['og_description'] }}">
<meta property="twitter:image" content="{{ $tags['og_image'] }}">

<!-- AEO & Search Schema (JSON-LD) -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@graph": [
        {
            "@@type": "Organization",
            "@@id": "{{ url('/') }}/#organization",
            "name": "Gamesiano",
            "url": "{{ url('/') }}",
            "logo": {
                "@@type": "ImageObject",
                "url": "{{ asset('images/logo_dark.png') }}"
            },
            "sameAs": [
                "https://facebook.com/gamesiano",
                "https://twitter.com/gamesiano",
                "https://instagram.com/gamesiano"
            ]
        },
        {
            "@@type": "WebSite",
            "@@id": "{{ url('/') }}/#website",
            "url": "{{ url('/') }}",
            "name": "Gamesiano",
            "description": "{{ __('The ultimate hub for interactive games and challenges.') }}",
            "publisher": {
                "@@id": "{{ url('/') }}/#organization"
            },
            "potentialAction": {
                "@@type": "SearchAction",
                "target": {
                    "@@type": "EntryPoint",
                    "urlTemplate": "{{ url(app()->getLocale() . '/library') }}?search={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            },
            "inLanguage": ["en", "ar"]
        }
    ]
}
</script>

@props(['title' => null, 'description' => null])
@php
    $c = config('church');
    $fullName = $c['name'].' '.$c['branch'];
    $services = \App\Models\ServiceTime::orderBy('sort')->get();
    $nav = ['about' => 'About', 'ministries' => 'Ministries', 'events' => 'Events', 'watch' => 'Watch', 'give' => 'Give', 'contact' => 'Visit us'];
    $jsonLd = [
        '@context' => 'https://schema.org', '@type' => 'Church', 'name' => $fullName, 'url' => url('/'),
        'logo' => asset('images/favicon.png'), 'image' => asset('images/gt-worship.jpg'),
        'telephone' => '+27'.ltrim(str_replace(' ', '', $c['phones'][0]), '0'),
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => '5 Hancock Street', 'addressLocality' => 'North End, Gqeberha', 'addressRegion' => 'Eastern Cape', 'addressCountry' => 'ZA'],
        'sameAs' => [$c['facebook']],
    ];
@endphp
<!DOCTYPE html>
<html lang="en-ZA">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' | '.$fullName : $fullName.', Gqeberha' }}</title>
    <meta name="description" content="{{ $description ?? $c['vision'].' Sundays 09:00 at '.$c['address'].'.' }}">
    <meta name="theme-color" content="#0a2370">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? $fullName }}">
    <meta property="og:description" content="{{ $description ?? $c['vision'] }}">
    <meta property="og:image" content="{{ asset('images/gt-worship.jpg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="GT Bethel">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <script type="application/ld+json">@json($jsonLd, JSON_UNESCAPED_SLASHES)</script>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<a href="#main" class="sr-only z-[60] rounded-md bg-gold-500 px-4 py-2 font-semibold text-navy-950 focus:not-sr-only focus:fixed focus:top-3 focus:left-3">Skip to content</a>

<header class="fixed inset-x-0 top-0 z-50 bg-navy-900/90 backdrop-blur-md">
    <div class="mx-auto flex h-18 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6">
        <a href="{{ route('home') }}" class="shrink-0">
            <img src="{{ asset('images/GTLOGO_SIDE_BY_Side-White.png') }}" alt="{{ $fullName }}, home" class="h-10 w-auto sm:h-12" width="1449" height="322">
        </a>
        <nav aria-label="Main" class="hidden lg:block">
            <ul class="flex gap-7 text-[15px] font-medium">
                @foreach ($nav as $route => $label)
                    @php $active = request()->routeIs($route); @endphp
                    <li>
                        <a href="{{ route($route) }}" @if ($active) aria-current="page" @endif
                           class="relative py-2 transition-colors hover:text-white {{ $active ? 'text-white after:absolute after:inset-x-0 after:-bottom-0.5 after:h-0.5 after:bg-cross' : 'text-white/75' }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <a href="{{ route('prayer') }}" class="btn-gold hidden min-h-11! px-4! lg:inline-flex">Ask for prayer</a>
        <button type="button" class="grid size-11 place-items-center rounded-md text-white hover:bg-white/10 lg:hidden" data-menu-toggle aria-controls="mobile-nav" aria-expanded="false">
            <span class="sr-only">Menu</span>
            <x-glyph name="menu" class="size-6" data-open />
            <x-glyph name="x" class="hidden size-6" data-close />
        </button>
    </div>
    <nav id="mobile-nav" aria-label="Mobile" class="border-t border-white/10 bg-navy-900 lg:hidden" hidden>
        <ul class="mx-auto max-w-6xl px-4 py-2 text-lg font-medium text-white sm:px-6">
            @foreach ($nav + ['connect' => 'I’m new here'] as $route => $label)
                <li><a href="{{ route($route) }}" @if (request()->routeIs($route)) aria-current="page" @endif class="block border-b border-white/10 py-3.5 aria-[current=page]:text-gold-400">{{ $label }}</a></li>
            @endforeach
            <li class="py-4"><a href="{{ route('prayer') }}" class="btn-gold w-full">Ask for prayer</a></li>
        </ul>
    </nav>
</header>

<main id="main">
    {{ $slot }}
</main>

<footer class="bg-navy-950 text-white/75">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-12">
        <div class="md:col-span-5">
            <img src="{{ asset('images/GTLOGO_SIDE_BY_Side-White.png') }}" alt="{{ $fullName }}" class="h-12 w-auto" loading="lazy" width="1449" height="322">
            <p class="mt-5 max-w-sm">{{ $c['vision'] }}</p>
            <p class="mt-5">{{ $c['address'] }}<br>
                @foreach ($c['phones'] as $ph)<a href="tel:+27{{ ltrim(str_replace(' ', '', $ph), '0') }}" class="hover:text-white">{{ $ph }}</a>@if (! $loop->last) &nbsp;/&nbsp; @endif @endforeach
            </p>
        </div>
        <div class="md:col-span-3">
            <p class="font-semibold text-white">Every week</p>
            <ul class="mt-3 space-y-1.5">
                @foreach ($services as $s)
                    <li>{{ $s->day }} {{ $s->time }}<br><span class="text-white/55">{{ $s->name }}</span></li>
                @endforeach
            </ul>
        </div>
        <nav aria-label="Footer" class="md:col-span-4">
            <p class="font-semibold text-white">Find your way</p>
            <ul class="mt-3 grid grid-cols-2 gap-x-6 gap-y-1.5">
                @foreach ($nav + ['connect' => 'I’m new here', 'prayer' => 'Ask for prayer', 'privacy' => 'Privacy'] as $route => $label)
                    <li><a href="{{ route($route) }}" class="hover:text-white">{{ $label }}</a></li>
                @endforeach
                <li><a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white"><x-glyph name="facebook" class="size-4" /> Facebook</a></li>
                <li><a href="https://wa.me/{{ $c['whatsapp'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white"><x-glyph name="message" class="size-4" /> WhatsApp</a></li>
            </ul>
        </nav>
    </div>
    <p class="mx-auto max-w-6xl border-t border-white/10 px-4 py-6 text-sm text-white/55 sm:px-6">&copy; {{ date('Y') }} {{ $fullName }}. <span class="font-serif italic">{{ $c['tagline'] }}</span></p>
</footer>
</body>
</html>

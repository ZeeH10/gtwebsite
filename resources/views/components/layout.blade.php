@props(['title' => null, 'description' => null])
@php
    $c = config('church');
    $fullName = $c['name'].' '.$c['branch'];
    $nav = ['home' => 'Home', 'about' => 'About', 'ministries' => 'Ministries', 'events' => 'Events', 'watch' => 'Watch', 'give' => 'Give', 'contact' => 'Visit & Contact'];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' | '.$fullName : $fullName.' | Church in North End, Gqeberha' }}</title>
    <meta name="description" content="{{ $description ?? $c['vision'].' Join us Sundays 09:00 at '.$c['address'].'.' }}">
    <meta name="theme-color" content="#0a2370">
    <meta property="og:title" content="{{ $title ?? $fullName }}">
    <meta property="og:description" content="{{ $description ?? $c['vision'] }}">
    <meta property="og:image" content="{{ asset('images/gt-worship.jpg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<a href="#main" class="sr-only z-[60] rounded bg-gold-500 px-4 py-2 font-semibold text-navy-950 focus:not-sr-only focus:fixed focus:top-3 focus:left-3">Skip to content</a>

<header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-navy-900/85 backdrop-blur-md">
    <div class="mx-auto flex h-18 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6">
        <a href="{{ route('home') }}" class="shrink-0">
            <img src="{{ asset('images/GTLOGO_SIDE_BY_Side-White.png') }}" alt="{{ $fullName }} home" class="h-10 w-auto sm:h-12" width="1449" height="322">
        </a>
        <nav aria-label="Main" class="hidden lg:block">
            <ul class="flex gap-6 font-display text-[13px] font-semibold uppercase tracking-wider">
                @foreach ($nav as $route => $label)
                    @php $active = request()->routeIs($route); @endphp
                    <li>
                        <a href="{{ route($route) }}" @if ($active) aria-current="page" @endif
                           class="relative py-2 transition hover:text-gold-400 {{ $active ? 'text-gold-400 after:absolute after:inset-x-0 after:-bottom-0.5 after:h-0.5 after:rounded-full after:bg-cross' : 'text-white/85' }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <a href="{{ route('prayer') }}" class="btn-gold hidden min-h-10! px-5! lg:inline-flex">Prayer request</a>
        <button type="button" class="grid size-11 place-items-center rounded-lg text-white hover:bg-white/10 lg:hidden" data-menu-toggle aria-controls="mobile-nav" aria-expanded="false">
            <span class="sr-only">Menu</span>
            <x-icon name="menu" class="size-6" data-open />
            <x-icon name="x" class="hidden size-6" data-close />
        </button>
    </div>
    <nav id="mobile-nav" aria-label="Mobile" class="border-t border-white/10 bg-navy-900 lg:hidden" hidden>
        <ul class="mx-auto max-w-6xl px-4 py-3 font-display text-sm font-semibold uppercase tracking-wider text-white sm:px-6">
            @foreach ($nav as $route => $label)
                <li><a href="{{ route($route) }}" @if (request()->routeIs($route)) aria-current="page" @endif class="block border-b border-white/5 py-3.5 hover:text-gold-400 aria-[current=page]:text-gold-400">{{ $label }}</a></li>
            @endforeach
            <li class="pt-4 pb-2"><a href="{{ route('prayer') }}" class="btn-gold w-full">Prayer request</a></li>
        </ul>
    </nav>
</header>

<main id="main">
    {{ $slot }}
</main>

<footer class="bg-navy-950 text-white/75">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:px-6 md:grid-cols-4">
        <div class="md:col-span-2">
            <img src="{{ asset('images/GTLOGO_SIDE_BY_Side-White.png') }}" alt="{{ $fullName }}" class="h-14 w-auto" loading="lazy" width="1449" height="322">
            <p class="mt-5 max-w-sm">{{ $c['vision'] }}</p>
            <div class="mt-6 flex gap-3">
                <a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="grid size-11 place-items-center rounded-full bg-white/10 text-white transition hover:bg-gold-500 hover:text-navy-950" aria-label="Facebook group"><x-icon name="facebook" /></a>
                <a href="https://wa.me/{{ $c['whatsapp'] }}" target="_blank" rel="noopener" class="grid size-11 place-items-center rounded-full bg-white/10 text-white transition hover:bg-gold-500 hover:text-navy-950" aria-label="WhatsApp"><x-icon name="message" /></a>
            </div>
        </div>
        <nav aria-label="Footer">
            <p class="font-display text-sm font-bold tracking-widest text-white uppercase">Explore</p>
            <ul class="mt-4 space-y-2">
                @foreach ($nav + ['prayer' => 'Prayer request'] as $route => $label)
                    <li><a href="{{ route($route) }}" class="hover:text-gold-400">{{ $label }}</a></li>
                @endforeach
            </ul>
        </nav>
        <div>
            <p class="font-display text-sm font-bold tracking-widest text-white uppercase">Service times</p>
            <ul class="mt-4 space-y-2">
                @foreach ($c['services'] as $s)
                    <li><span class="text-white">{{ $s['day'] }} {{ $s['time'] }}</span><br>{{ $s['name'] }}</li>
                @endforeach
            </ul>
            <p class="mt-5 flex gap-2"><x-icon name="map-pin" class="mt-0.5 text-gold-400" /> {{ $c['address'] }}</p>
        </div>
    </div>
    <div class="border-t border-white/10">
        <p class="mx-auto max-w-6xl px-4 py-6 text-sm sm:px-6">&copy; {{ date('Y') }} {{ $fullName }}, Gqeberha. <span class="font-serif italic">{{ $c['tagline'] }}</span></p>
    </div>
</footer>
</body>
</html>

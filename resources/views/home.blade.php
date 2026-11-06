@php
    use App\Models\{Event, Ministry, ServiceTime, Setting};
    $c = config('church');
    $services = ServiceTime::orderBy('sort')->get();
    $sunday = $services->firstWhere('day', 'Sunday') ?? $services->first();
    $events = Event::upcoming()->take(4)->get();
    $featured = $events->shift();
    $ministries = Ministry::where('is_published', true)->whereNotNull('image')->orderBy('sort')->take(3)->get();
@endphp
<x-layout>
{{-- HERO: the church's motto, set large, with the logo's arrow drawing across it --}}
<section class="relative isolate flex min-h-[92svh] flex-col justify-end overflow-hidden bg-navy-900 pt-18 text-white">
    <img src="{{ asset('images/gt-worship.jpg') }}" alt="" class="absolute inset-0 -z-20 size-full object-cover opacity-45 mix-blend-luminosity" fetchpriority="high">
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(100deg,var(--color-navy-950)_10%,rgb(10_35_112/0.75)_55%,rgb(23_71_201/0.45))]"></div>

    {{-- Signature: the sweeping arrow from the logo (globe + arrow = "we are going") --}}
    <svg class="arrow-draw pointer-events-none absolute top-20 right-[-3%] -z-10 w-[58%] max-w-[760px] text-gold-500 sm:top-24 sm:right-0 sm:w-[60%]" viewBox="0 0 600 420" fill="none" aria-hidden="true">
        <path pathLength="1" d="M60 330 C 20 230, 50 110, 190 80 C 260 62, 320 60, 520 60" stroke="currentColor" stroke-width="14" stroke-linecap="round" />
        <path class="arrow-head" pathLength="1" d="M470 14 L 548 60 L 470 106" stroke="currentColor" stroke-width="14" stroke-linecap="round" stroke-linejoin="round" />
    </svg>

    <div class="mx-auto w-full max-w-6xl px-4 pt-20 pb-10 sm:px-6 sm:pb-14">
        <h1 class="text-base font-semibold text-gold-300! sm:text-lg">{{ $c['name'] }} {{ $c['branch'] }}, Gqeberha</h1>
        <p class="mt-5 font-serif text-2xl text-white/90 italic sm:text-3xl">“Go ye therefore…”</p>
        <p class="display mt-1 text-[clamp(2.9rem,9vw,6.5rem)] leading-[0.95]">We are<br>going.</p>
        <p class="mt-5"><span class="brush">Matthew 28:19</span></p>

        @if ($sunday)
            <div class="mt-12 flex flex-col gap-5 border-t border-white/20 pt-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="font-display text-xl font-semibold sm:text-2xl">Join us {{ $sunday->day }}, {{ $sunday->time }}</p>
                    <p class="mt-1 text-white/80">{{ $sunday->name }} at {{ $c['address'] }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($c['address']) }}" target="_blank" rel="noopener" class="btn-gold">Get directions</a>
                    <a href="{{ route('connect') }}" class="btn-light">I’m new here</a>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- WELCOME + PASTOR --}}
<section class="py-20 sm:py-24">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16">
        <div class="lg:col-span-7">
            <h2 class="h2">Welcome to the family</h2>
            <p class="prose-width mt-5 text-lg">{{ $c['welcome'] }}</p>
            <p class="prose-width mt-4">{{ $c['vision'] }}</p>
            <a href="{{ route('about') }}" class="link mt-6 inline-block">Read our story</a>

            <h2 class="h2 mt-14">Every week</h2>
            <div class="mt-5">@include('partials.timetable')</div>
        </div>
        <figure class="lg:col-span-5">
            <img src="{{ asset('images/'.$c['pastor']['image']) }}" alt="{{ Setting::get('pastor_name') }}" class="aspect-[4/5] w-full rounded-xl bg-royal object-cover object-top" width="350" height="350">
            <figcaption class="mt-4">
                <p class="h3">{{ Setting::get('pastor_name') }}</p>
                <p class="text-slate-600">{{ Setting::get('pastor_title') }}</p>
            </figcaption>
        </figure>
    </div>
</section>

{{-- EVENTS --}}
@if ($featured)
<section class="bg-mist py-20 sm:py-24">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="flex flex-wrap items-baseline justify-between gap-4">
            <h2 class="h2">Coming up</h2>
            <a href="{{ route('events') }}" class="link">All events</a>
        </div>
        <article class="mt-8 grid gap-8 md:grid-cols-2 md:items-center">
            @if ($featured->image_url)
                <img src="{{ $featured->image_url }}" alt="" class="w-full rounded-xl {{ $featured->image_is_poster ? 'object-contain bg-navy-900' : 'aspect-[4/3] object-cover' }}" loading="lazy">
            @endif
            <div>
                <p class="flex items-center gap-2 text-sm font-semibold text-cross"><span class="size-2 rounded-full bg-cross"></span> Next event</p>
                <h3 class="mt-3 font-display text-2xl leading-tight font-semibold sm:text-3xl">{{ $featured->title }}</h3>
                <p class="mt-3 text-royal-700">
                    {{ $featured->ends_on ? $featured->starts_on->format('l j M').' to '.$featured->ends_on->format('l j M Y') : $featured->starts_on->format('l j F Y') }}@if ($featured->time), {{ $featured->time }}@endif
                </p>
                @if ($featured->summary) <p class="prose-width mt-4 text-lg">{{ $featured->summary }}</p> @endif
            </div>
        </article>
        @if ($events->isNotEmpty())
            <ul class="mt-10 divide-y divide-slate-200 border-t border-slate-200">
                @foreach ($events as $e) @include('partials.event-row') @endforeach
            </ul>
        @endif
    </div>
</section>
@endif

{{-- MINISTRIES --}}
<section class="py-20 sm:py-24">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="flex flex-wrap items-baseline justify-between gap-4">
            <h2 class="h2">Find your place</h2>
            <a href="{{ route('ministries') }}" class="link">All ministries and home groups</a>
        </div>
        <ul class="mt-6 divide-y divide-slate-200">
            @foreach ($ministries as $m) @include('partials.ministry-row') @endforeach
        </ul>
    </div>
</section>

@include('partials.connect-band')
</x-layout>

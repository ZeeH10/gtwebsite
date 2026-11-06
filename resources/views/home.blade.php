@php
    $c = config('church');
    $upcoming = collect($c['events'])->filter(fn ($e) => \Illuminate\Support\Carbon::parse($e['end'] ?? $e['date'])->endOfDay()->isFuture())->sortBy('date')->take(3);
@endphp
<x-layout>
{{-- HERO --}}
<section class="beams relative flex min-h-svh flex-col bg-navy-900 pt-18">
    <img src="{{ asset('images/gt-worship.jpg') }}" alt="" class="absolute inset-0 -z-10 size-full object-cover" fetchpriority="high">
    <div class="absolute inset-0 -z-10 bg-linear-to-b from-navy-900/85 via-royal-700/55 to-navy-950/95"></div>
    <div class="absolute inset-x-0 top-0 -z-10 h-2/3 bg-[radial-gradient(ellipse_60%_60%_at_50%_0%,rgb(140_195_255/0.4),transparent_70%)]"></div>

    <div class="mx-auto flex w-full max-w-6xl flex-1 flex-col items-center justify-center px-4 py-16 text-center sm:px-6">
        <p class="font-serif text-lg text-gold-300 italic sm:text-xl">{{ $c['tagline'] }} <span class="not-italic text-white/75">— {{ $c['tagline_ref'] }}</span></p>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight text-balance text-white uppercase drop-shadow-lg sm:text-6xl lg:text-7xl">
            {{ $c['name'] }}
            <span class="mt-4 block text-xl tracking-[0.35em] text-gold-400 sm:text-3xl">{{ $c['branch'] }}</span>
        </h1>
        <div class="mt-8 flex items-center gap-3" aria-hidden="true">
            <span class="h-0.5 w-20 rounded-full bg-linear-to-r from-transparent to-gold-500"></span>
            <x-icon name="cross" class="size-6 text-cross" stroke-width="3" />
            <span class="h-0.5 w-20 rounded-full bg-linear-to-l from-transparent to-gold-500"></span>
        </div>
        <p class="mt-8 max-w-2xl text-lg text-white/90 sm:text-xl">{{ $c['vision'] }}</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="btn-gold">Plan your visit <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('prayer') }}" class="btn-outline">Send a prayer request</a>
        </div>
    </div>

    <div class="border-t border-white/15 bg-navy-950/75 backdrop-blur">
        <ul class="mx-auto grid max-w-6xl divide-white/15 px-4 sm:grid-cols-3 sm:divide-x sm:px-6" aria-label="Weekly services">
            @foreach ($c['services'] as $s)
                <li class="flex items-center gap-4 py-5 sm:justify-center sm:px-4">
                    <span class="grid size-11 place-items-center rounded-full bg-gold-500/20 text-gold-400 ring-1 ring-gold-400/40"><x-icon :name="$s['icon']" /></span>
                    <div>
                        <p class="font-display text-xs font-bold tracking-widest text-gold-400 uppercase">{{ $s['day'] }} · {{ $s['time'] }}</p>
                        <p class="font-display font-bold text-white">{{ $s['name'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- WELCOME + PASTOR --}}
<section class="py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16">
        <div class="relative" data-reveal>
            <img src="{{ asset('images/gt-pastor.jpg') }}" alt="A service at Bethel Centre" class="aspect-[4/3] w-full rounded-2xl object-cover shadow-xl" loading="lazy" width="1024" height="765">
            <figure class="absolute -bottom-8 left-4 flex items-center gap-4 rounded-2xl bg-royal-700 p-3 pr-6 text-white shadow-xl sm:left-auto sm:-right-6">
                <img src="{{ asset('images/'.$c['pastor']['image']) }}" alt="{{ $c['pastor']['name'] }}" class="size-16 rounded-xl object-cover ring-2 ring-gold-400" width="350" height="350">
                <figcaption>
                    <p class="font-display font-bold">{{ $c['pastor']['name'] }}</p>
                    <p class="text-sm text-white/80">{{ $c['pastor']['title'] }}</p>
                </figcaption>
            </figure>
        </div>
        <div data-reveal>
            <p class="eyebrow">Welcome home</p>
            <h2 class="h2">A Christ-centred family in North End, Gqeberha</h2>
            <p class="mt-6 text-lg leading-relaxed">{{ $c['welcome'] }}</p>
            <p class="mt-4 leading-relaxed">We exist to fulfil the Great Commission of Matthew 28:19, and our heartfelt response is simple: <strong class="text-navy-900">we are going.</strong></p>
            <a href="{{ route('about') }}" class="btn-navy mt-8">More about us <x-icon name="arrow-right" class="size-4" /></a>
        </div>
    </div>
</section>

{{-- MINISTRIES PREVIEW --}}
<section class="bg-mist py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-6" data-reveal>
            <div class="max-w-2xl">
                <p class="eyebrow">Ministries</p>
                <h2 class="h2">There’s a place for you to belong and serve</h2>
            </div>
            <a href="{{ route('ministries') }}" class="inline-flex items-center gap-1 font-display font-bold text-royal-700 hover:underline">All ministries <x-icon name="arrow-right" class="size-4" /></a>
        </div>
        <ul class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (array_slice($c['ministries'], 0, 3) as $m)
                @include('partials.ministry-card')
            @endforeach
        </ul>
    </div>
</section>

{{-- UPCOMING EVENTS --}}
@if ($upcoming->isNotEmpty())
<section class="py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-6" data-reveal>
            <div>
                <p class="eyebrow">Events</p>
                <h2 class="h2">What’s coming up</h2>
            </div>
            <a href="{{ route('events') }}" class="inline-flex items-center gap-1 font-display font-bold text-royal-700 hover:underline">All events <x-icon name="arrow-right" class="size-4" /></a>
        </div>
        <ul class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach ($upcoming as $e)
                @include('partials.event-card')
            @endforeach
        </ul>
    </div>
</section>
@endif

@include('partials.scripture', ['verse' => 'For God so loved the world, that he gave his only begotten Son, that whosoever believeth in him should not perish, but have everlasting life.', 'ref' => 'John 3:16'])

{{-- NEXT STEPS --}}
<section class="py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl" data-reveal>
            <p class="eyebrow">Next steps</p>
            <h2 class="h2">How can we walk with you?</h2>
        </div>
        <ul class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach ([
                ['Plan a visit', 'Service times, directions and what to expect on a Sunday.', 'contact', 'map-pin'],
                ['Ask for prayer', 'Share a request with our pastors and prayer team.', 'prayer', 'heart'],
                ['Give', 'Partner with the work of the ministry through your giving.', 'give', 'hand-heart'],
            ] as [$t, $d, $r, $i])
                <li data-reveal>
                    <a href="{{ route($r) }}" class="group card flex h-full flex-col p-8 transition hover:-translate-y-1 hover:shadow-xl hover:">
                        <span class="grid size-14 place-items-center rounded-2xl bg-royal-700 text-gold-400 shadow-lg"><x-icon :name="$i" class="size-6" /></span>
                        <h3 class="mt-6 font-display text-xl font-bold text-navy-900">{{ $t }}</h3>
                        <p class="mt-2 flex-1 text-slate-600">{{ $d }}</p>
                        <span class="mt-6 inline-flex items-center gap-1 font-display text-sm font-bold text-royal-700 uppercase">Go <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" /></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>
</x-layout>

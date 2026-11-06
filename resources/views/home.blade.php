@php
    $c = config('church');
    $fullName = $c['name'].' '.$c['branch'];
    $mapQuery = urlencode($c['address']);
    $nav = ['about' => 'About', 'visit' => 'Visit', 'ministries' => 'Ministries', 'watch' => 'Watch', 'events' => 'Events', 'give' => 'Give', 'contact' => 'Contact'];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullName }} | Church in North End, Gqeberha</title>
    <meta name="description" content="{{ $c['vision'] }} Join us Sundays 09:00 at {{ $c['address'] }}.">
    <meta name="theme-color" content="#0e1538">
    <meta property="og:title" content="{{ $fullName }}">
    <meta property="og:description" content="{{ $c['vision'] }}">
    <meta property="og:image" content="{{ asset('images/gt-worship.jpg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<a href="#main" class="sr-only z-[60] rounded bg-gold-500 px-4 py-2 font-semibold text-navy-950 focus:not-sr-only focus:fixed focus:top-3 focus:left-3">Skip to content</a>

{{-- ============ HEADER ============ --}}
<header id="top" class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-navy-950/85 backdrop-blur-md">
    <div class="mx-auto flex h-18 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6">
        <a href="#top" class="shrink-0">
            <img src="{{ asset('images/GTLOGO_SIDE_BY_Side-White.png') }}" alt="{{ $fullName }} home" class="h-10 w-auto sm:h-12" width="1449" height="322">
        </a>
        <nav aria-label="Main" class="hidden lg:block">
            <ul class="flex gap-6 font-display text-[13px] font-semibold uppercase tracking-wider text-white/80">
                @foreach ($nav as $id => $label)
                    <li><a href="#{{ $id }}" class="py-2 transition hover:text-gold-400">{{ $label }}</a></li>
                @endforeach
            </ul>
        </nav>
        <a href="#prayer" class="btn-gold hidden min-h-10! px-5! lg:inline-flex">Prayer request</a>
        <button type="button" class="grid size-11 place-items-center rounded-lg text-white hover:bg-white/10 lg:hidden" data-menu-toggle aria-controls="mobile-nav" aria-expanded="false">
            <span class="sr-only">Menu</span>
            <x-icon name="menu" class="size-6" data-open />
            <x-icon name="x" class="hidden size-6" data-close />
        </button>
    </div>
    <nav id="mobile-nav" aria-label="Mobile" class="border-t border-white/10 bg-navy-950 lg:hidden" hidden>
        <ul class="mx-auto max-w-6xl px-4 py-3 font-display text-sm font-semibold uppercase tracking-wider text-white sm:px-6">
            @foreach ($nav as $id => $label)
                <li><a href="#{{ $id }}" class="block border-b border-white/5 py-3.5 hover:text-gold-400">{{ $label }}</a></li>
            @endforeach
            <li class="pt-4 pb-2"><a href="#prayer" class="btn-gold w-full">Prayer request</a></li>
        </ul>
    </nav>
</header>

<main id="main">
{{-- ============ HERO ============ --}}
<section class="relative isolate flex min-h-svh flex-col overflow-hidden bg-navy-950 pt-18">
    <img src="{{ asset('images/gt-worship.jpg') }}" alt="" class="absolute inset-0 -z-10 size-full object-cover" fetchpriority="high">
    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-navy-950/85 via-navy-900/60 to-navy-950"></div>

    <div class="mx-auto flex w-full max-w-6xl flex-1 flex-col items-center justify-center px-4 py-16 text-center sm:px-6">
        <p class="font-serif text-lg text-gold-300 italic sm:text-xl">{{ $c['tagline'] }} <span class="not-italic text-white/70">— {{ $c['tagline_ref'] }}</span></p>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight text-balance text-white uppercase sm:text-6xl lg:text-7xl">
            {{ $c['name'] }}
            <span class="mt-4 block text-xl tracking-[0.35em] text-gold-400 sm:text-3xl">{{ $c['branch'] }}</span>
        </h1>
        <span class="mt-8 h-1 w-16 rounded-full bg-gold-500" aria-hidden="true"></span>
        <p class="mt-8 max-w-2xl text-lg text-white/85 sm:text-xl">{{ $c['vision'] }}</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="#visit" class="btn-gold">Plan your visit <x-icon name="arrow-right" class="size-4" /></a>
            <a href="#prayer" class="btn-outline">Send a prayer request</a>
        </div>
    </div>

    <div class="border-t border-white/10 bg-navy-950/75 backdrop-blur">
        <ul class="mx-auto grid max-w-6xl divide-white/10 px-4 sm:grid-cols-3 sm:divide-x sm:px-6" aria-label="Weekly services">
            @foreach ($c['services'] as $s)
                <li class="flex items-center gap-4 py-5 sm:justify-center sm:px-4">
                    <span class="grid size-11 place-items-center rounded-full bg-gold-500/15 text-gold-400"><x-icon :name="$s['icon']" /></span>
                    <div>
                        <p class="font-display text-xs font-bold tracking-widest text-gold-400 uppercase">{{ $s['day'] }} · {{ $s['time'] }}</p>
                        <p class="font-display font-bold text-white">{{ $s['name'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- ============ ABOUT ============ --}}
<section id="about" class="py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16">
        <div class="relative" data-reveal>
            <img src="{{ asset('images/gt-pastor.jpg') }}" alt="{{ $c['pastor']['name'] }} preaching at Bethel Centre" class="aspect-[4/3] w-full rounded-2xl object-cover shadow-xl" loading="lazy" width="1024" height="765">
            <div class="absolute -bottom-6 left-6 rounded-xl bg-navy-900 px-6 py-4 text-white shadow-lg sm:left-auto sm:-right-6">
                <p class="font-display font-bold">{{ $c['pastor']['name'] }}</p>
                <p class="text-sm text-white/75">{{ $c['pastor']['title'] }}</p>
            </div>
        </div>
        <div data-reveal>
            <p class="eyebrow">About us</p>
            <h2 class="h2">A Christ-centred family in North End, Gqeberha</h2>
            <p class="mt-6 text-lg leading-relaxed">{{ $c['welcome'] }}</p>
            <p class="mt-4 leading-relaxed">As part of the Glad Tidings Fellowship family of churches, we exist to fulfil the Great Commission of Matthew 28:19: <em class="font-serif">“Go ye therefore, and teach all nations…”</em> Our heartfelt response is simple: <strong class="text-navy-900">we are going.</strong></p>
            <ul class="mt-8 grid gap-4 sm:grid-cols-3">
                @foreach ([['Christ-centred', 'book'], ['Family-oriented', 'users'], ['Equipped to serve', 'hand-heart']] as [$v, $icon])
                    <li class="rounded-xl border border-slate-200 p-4">
                        <x-icon :name="$icon" class="size-6 text-sky-500" />
                        <p class="mt-3 font-display text-sm font-bold text-navy-900">{{ $v }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- ============ VISIT ============ --}}
<section id="visit" class="bg-mist py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl" data-reveal>
            <p class="eyebrow">Plan your visit</p>
            <h2 class="h2">Join us this week</h2>
            <p class="mt-4 text-lg">Whether it’s your first time in church or you’re looking for a new home, there’s a seat for you at Bethel Centre.</p>
        </div>
        <div class="mt-12 grid gap-6 lg:grid-cols-5">
            <ul class="grid gap-4 sm:grid-cols-3 lg:col-span-3 lg:grid-cols-1" data-reveal>
                @foreach ($c['services'] as $s)
                    <li class="flex items-center gap-5 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
                        <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-navy-900 text-gold-400"><x-icon :name="$s['icon']" class="size-6" /></span>
                        <div>
                            <p class="font-display text-xs font-bold tracking-widest text-sky-700 uppercase">{{ $s['day'] }}</p>
                            <p class="font-display text-lg font-bold text-navy-900">{{ $s['name'] }}</p>
                            <p class="flex items-center gap-1.5 text-slate-600"><x-icon name="clock" class="size-4" /> {{ $s['time'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="flex flex-col rounded-2xl bg-navy-900 p-8 text-white lg:col-span-2" data-reveal>
                <h3 class="font-display text-xl font-bold">What to expect</h3>
                <ul class="mt-5 space-y-3 text-white/85">
                    @foreach (['A warm welcome at the door', 'Lively praise and worship', 'Prayer and a message from the Word', 'Children’s church for the little ones'] as $item)
                        <li class="flex gap-3"><x-icon name="check" class="mt-0.5 text-gold-400" /> {{ $item }}</li>
                    @endforeach
                </ul>
                <div class="mt-8 flex items-start gap-3 border-t border-white/10 pt-6">
                    <x-icon name="map-pin" class="mt-0.5 text-gold-400" />
                    <p>{{ $c['address'] }}</p>
                </div>
                <div class="mt-auto flex flex-wrap gap-3 pt-8">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $mapQuery }}" target="_blank" rel="noopener" class="btn-gold">Get directions</a>
                    <a href="https://wa.me/{{ $c['whatsapp'] }}?text={{ urlencode('Hi! I’d like to visit Glad Tidings Bethel Centre this Sunday.') }}" target="_blank" rel="noopener" class="btn-outline">WhatsApp us</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ MINISTRIES ============ --}}
<section id="ministries" class="py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl" data-reveal>
            <p class="eyebrow">Ministries</p>
            <h2 class="h2">There’s a place for you to belong and serve</h2>
        </div>
        <ul class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($c['ministries'] as $m)
                <li class="group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition duration-200 hover:-translate-y-1 hover:shadow-lg" data-reveal>
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ asset('images/'.$m['image']) }}" alt="" class="size-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" width="1024" height="765">
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-lg font-bold text-navy-900">{{ $m['name'] }}</h3>
                        <p class="mt-2 text-slate-600">{{ $m['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- ============ HOME GROUPS ============ --}}
<section class="bg-mist py-20 sm:py-24">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2">
        <img src="{{ asset('images/gt-homegroup.jpg') }}" alt="Church members at a home group Bible study" class="aspect-[4/3] w-full rounded-2xl object-cover shadow-xl lg:order-2" loading="lazy" width="1024" height="765" data-reveal>
        <div data-reveal>
            <p class="eyebrow">Home groups · Tuesdays 18:00</p>
            <h2 class="h2">Church is better around a table</h2>
            <p class="mt-5 text-lg">Our home groups meet across Gqeberha every Tuesday evening to study the Bible, pray for one another and do life together. It’s the easiest way to get to know people at Bethel Centre.</p>
            <a href="https://wa.me/{{ $c['whatsapp'] }}?text={{ urlencode('Hi! I’d like to join a home group near me.') }}" target="_blank" rel="noopener" class="btn-navy mt-8"><x-icon name="message" class="size-4" /> Find a group near you</a>
        </div>
    </div>
</section>

{{-- ============ WATCH ============ --}}
<section id="watch" class="bg-navy-900 py-20 text-white sm:py-28">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2">
        <div data-reveal>
            <p class="eyebrow eyebrow-light">Watch &amp; listen</p>
            <h2 class="h2 text-white!">Can’t make it on Sunday?</h2>
            <p class="mt-5 text-lg text-white/80">Sermons and services will be streamed and uploaded here as our media ministry grows. In the meantime, join our Facebook group for updates, photos and announcements.</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="btn-gold"><x-icon name="facebook" class="size-4" /> Join our Facebook group</a>
                @if ($c['youtube'])
                    <a href="{{ $c['youtube'] }}" target="_blank" rel="noopener" class="btn-outline">YouTube channel</a>
                @endif
            </div>
        </div>
        <a href="{{ $c['youtube'] ?? $c['facebook'] }}" target="_blank" rel="noopener" class="group relative block aspect-video overflow-hidden rounded-2xl shadow-2xl ring-1 ring-white/10" data-reveal>
            <img src="{{ asset('images/gt-pastor.jpg') }}" alt="" class="size-full object-cover opacity-70 transition duration-500 group-hover:scale-105" loading="lazy" width="1024" height="765">
            <span class="absolute inset-0 grid place-items-center">
                <span class="grid size-20 place-items-center rounded-full bg-gold-500 text-navy-950 shadow-lg transition group-hover:scale-110"><x-icon name="play" class="size-8 translate-x-0.5" /></span>
            </span>
            <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-950 p-5 font-display font-bold">Latest message <span class="font-normal text-white/70">· coming soon</span></span>
        </a>
    </div>
</section>

{{-- ============ EVENTS ============ --}}
<section id="events" class="py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl" data-reveal>
            <p class="eyebrow">Events</p>
            <h2 class="h2">What’s coming up</h2>
        </div>
        <ul class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach ($c['events'] as $e)
                @php $d = \Illuminate\Support\Carbon::parse($e['date']); @endphp
                <li class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200" data-reveal>
                    <img src="{{ asset('images/'.$e['image']) }}" alt="" class="aspect-[16/10] w-full object-cover" loading="lazy" width="1024" height="640">
                    <div class="flex gap-5 p-6">
                        <time datetime="{{ $e['date'] }}" class="flex w-14 shrink-0 flex-col self-start items-center rounded-lg bg-navy-900 py-2 text-white">
                            <span class="font-display text-xs font-bold tracking-wider text-gold-400 uppercase">{{ $d->format('M') }}</span>
                            <span class="font-display text-2xl font-extrabold">{{ $d->format('j') }}</span>
                        </time>
                        <div>
                            <h3 class="font-display text-lg font-bold text-navy-900">{{ $e['name'] }}</h3>
                            <p class="mt-1 flex items-center gap-1.5 text-sm text-sky-700"><x-icon name="clock" class="size-4" /> {{ $d->format('l') }} · {{ $e['time'] }}</p>
                            <p class="mt-2 text-slate-600">{{ $e['text'] }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- ============ SCRIPTURE BAND ============ --}}
<section class="relative isolate overflow-hidden bg-navy-950 py-20 text-center text-white sm:py-24" aria-label="Scripture">
    <img src="{{ asset('images/gt-choir.jpg') }}" alt="" class="absolute inset-0 -z-10 size-full object-cover opacity-25" loading="lazy">
    <div class="mx-auto max-w-3xl px-4 sm:px-6" data-reveal>
        <x-icon name="heart" class="mx-auto size-8 text-cross" />
        <blockquote class="mt-6 font-serif text-2xl leading-relaxed text-balance italic sm:text-3xl">“For God so loved the world, that he gave his only begotten Son, that whosoever believeth in him should not perish, but have everlasting life.”</blockquote>
        <p class="mt-6 font-display text-sm font-bold tracking-[0.25em] text-gold-400 uppercase">John 3:16</p>
    </div>
</section>

{{-- ============ GIVE ============ --}}
<section id="give" class="bg-mist py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center">
        <div data-reveal>
            <p class="eyebrow">Give</p>
            <h2 class="h2">Partner with the work of the ministry</h2>
            <p class="mt-5 text-lg">Your giving supports the church, its pastors and members in every season of life. You can give by EFT using the details here, or in person at any service.</p>
            <ul class="mt-8 flex flex-wrap gap-2">
                @foreach ($c['giving']['purposes'] as $p)
                    <li class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-navy-900 ring-1 ring-slate-200">{{ $p }}</li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl bg-navy-900 p-8 text-white shadow-xl sm:p-10" data-reveal>
            <h3 class="flex items-center gap-3 font-display text-xl font-bold"><x-icon name="hand-heart" class="size-6 text-gold-400" /> Banking details</h3>
            <dl class="mt-6 divide-y divide-white/10">
                @foreach (['Bank' => $c['giving']['bank'], 'Account name' => $c['giving']['account_name'], 'Account number' => $c['giving']['account_number'], 'Branch code' => $c['giving']['branch_code']] as $k => $v)
                    <div class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-3">
                        <dt class="text-white/65">{{ $k }}</dt>
                        <dd class="font-semibold">{{ $v }}</dd>
                    </div>
                @endforeach
            </dl>
            <p class="mt-6 rounded-lg bg-white/5 p-4 text-sm text-white/80">Reference: <strong class="text-gold-300">your name + purpose</strong>, e.g. “T Moyo Tithe” or “T Moyo Funeral”.</p>
        </div>
    </div>
</section>

{{-- ============ PRAYER ============ --}}
<section id="prayer" class="px-4 py-20 sm:px-6 sm:py-28">
    <div class="mx-auto grid max-w-6xl overflow-hidden rounded-3xl shadow-xl ring-1 ring-slate-200 lg:grid-cols-5">
        <div class="relative isolate flex flex-col justify-end bg-navy-900 p-8 text-white sm:p-10 lg:col-span-2">
            <img src="{{ asset('images/gt-prayer.jpg') }}" alt="" class="absolute inset-0 -z-10 size-full object-cover opacity-40" loading="lazy">
            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-navy-950 via-navy-950/60"></div>
            <p class="eyebrow eyebrow-light">Prayer requests</p>
            <h2 class="h2 text-white!">How can we pray for you?</h2>
            <blockquote class="mt-6 font-serif text-white/85 italic">“If two of you shall agree on earth as touching any thing that they shall ask, it shall be done for them of my Father which is in heaven.”</blockquote>
            <p class="mt-3 font-display text-xs font-bold tracking-[0.25em] text-gold-400 uppercase">Matthew 18:19</p>
        </div>

        <div class="bg-white p-8 sm:p-10 lg:col-span-3">
            @if (session('prayer_sent'))
                <div role="status" class="flex gap-4 rounded-xl bg-emerald-50 p-6 text-emerald-900 ring-1 ring-emerald-200">
                    <x-icon name="check" class="size-6 text-emerald-600" />
                    <div>
                        <p class="font-display font-bold">Thank you, your request has been received.</p>
                        <p class="mt-1">Our prayer team will be standing with you. If you left contact details, someone may reach out.</p>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('prayer.store') }}" class="space-y-5" novalidate>
                    @csrf
                    <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="font-semibold text-navy-900">Name <span class="font-normal text-slate-500">(optional)</span></label>
                            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" class="field" maxlength="100">
                        </div>
                        <div>
                            <label for="contact" class="font-semibold text-navy-900">Phone or email <span class="font-normal text-slate-500">(optional)</span></label>
                            <input id="contact" name="contact" type="text" autocomplete="email" value="{{ old('contact') }}" class="field" maxlength="150">
                        </div>
                    </div>
                    <div>
                        <label for="request" class="font-semibold text-navy-900">Your prayer request</label>
                        <textarea id="request" name="request" rows="6" required maxlength="3000" class="field @error('request') border-red-500! @enderror" @error('request') aria-invalid="true" aria-describedby="request-error" @enderror>{{ old('request') }}</textarea>
                        @error('request') <p id="request-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <label class="flex cursor-pointer items-start gap-3">
                        <input type="checkbox" name="pastors_only" value="1" @checked(old('pastors_only')) class="mt-1 size-5 rounded border-slate-300 accent-navy-900">
                        <span>Keep this confidential: share with the pastors only</span>
                    </label>
                    <button type="submit" class="btn-navy w-full sm:w-auto">Send prayer request</button>
                </form>
            @endif
        </div>
    </div>
</section>

{{-- ============ CONTACT ============ --}}
<section id="contact" class="bg-mist py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl" data-reveal>
            <p class="eyebrow">Contact</p>
            <h2 class="h2">We’d love to hear from you</h2>
        </div>
        <div class="mt-12 grid gap-6 lg:grid-cols-5">
            <ul class="grid gap-4 sm:grid-cols-2 lg:col-span-2 lg:grid-cols-1" data-reveal>
                <li class="flex gap-4 rounded-2xl bg-white p-6 ring-1 ring-slate-200">
                    <x-icon name="map-pin" class="size-6 text-sky-500" />
                    <div><p class="font-display font-bold text-navy-900">Visit us</p><p class="mt-1">{{ $c['address'] }}</p></div>
                </li>
                <li class="flex gap-4 rounded-2xl bg-white p-6 ring-1 ring-slate-200">
                    <x-icon name="phone" class="size-6 text-sky-500" />
                    <div>
                        <p class="font-display font-bold text-navy-900">Call us</p>
                        @foreach ($c['phones'] as $ph)
                            <a href="tel:+27{{ ltrim(str_replace(' ', '', $ph), '0') }}" class="mt-1 block text-sky-700 hover:underline">{{ $ph }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="flex gap-4 rounded-2xl bg-white p-6 ring-1 ring-slate-200">
                    <x-icon name="message" class="size-6 text-sky-500" />
                    <div><p class="font-display font-bold text-navy-900">WhatsApp</p><a href="https://wa.me/{{ $c['whatsapp'] }}" target="_blank" rel="noopener" class="mt-1 block text-sky-700 hover:underline">Send us a message</a></div>
                </li>
                <li class="flex gap-4 rounded-2xl bg-white p-6 ring-1 ring-slate-200">
                    <x-icon name="facebook" class="size-6 text-sky-500" />
                    <div><p class="font-display font-bold text-navy-900">Facebook</p><a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="mt-1 block text-sky-700 hover:underline">facebook.com/groups/gtfec</a></div>
                </li>
            </ul>
            <iframe title="Map showing {{ $c['address'] }}" src="https://maps.google.com/maps?q={{ $mapQuery }}&z=16&output=embed" class="min-h-80 w-full rounded-2xl border-0 shadow-sm ring-1 ring-slate-200 lg:col-span-3" loading="lazy" referrerpolicy="no-referrer-when-downgrade" data-reveal></iframe>
        </div>
    </div>
</section>
</main>

{{-- ============ FOOTER ============ --}}
<footer class="bg-navy-950 text-white/75">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:px-6 md:grid-cols-3">
        <div>
            <img src="{{ asset('images/GTLOGO_SIDE_BY_Side-White.png') }}" alt="{{ $fullName }}" class="h-14 w-auto" loading="lazy" width="1449" height="322">
            <p class="mt-5 max-w-xs">{{ $c['vision'] }}</p>
        </div>
        <nav aria-label="Footer">
            <p class="font-display text-sm font-bold tracking-widest text-white uppercase">Explore</p>
            <ul class="mt-4 grid grid-cols-2 gap-2">
                @foreach ($nav + ['prayer' => 'Prayer'] as $id => $label)
                    <li><a href="#{{ $id }}" class="hover:text-gold-400">{{ $label }}</a></li>
                @endforeach
            </ul>
        </nav>
        <div>
            <p class="font-display text-sm font-bold tracking-widest text-white uppercase">Service times</p>
            <ul class="mt-4 space-y-2">
                @foreach ($c['services'] as $s)
                    <li><span class="text-white">{{ $s['day'] }} {{ $s['time'] }}</span> · {{ $s['name'] }}</li>
                @endforeach
            </ul>
            <a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="mt-6 inline-grid size-11 place-items-center rounded-full bg-white/10 text-white transition hover:bg-gold-500 hover:text-navy-950" aria-label="Facebook group">
                <x-icon name="facebook" />
            </a>
        </div>
    </div>
    <div class="border-t border-white/10">
        <p class="mx-auto max-w-6xl px-4 py-6 text-sm sm:px-6">&copy; {{ date('Y') }} {{ $fullName }}, Gqeberha. <span class="font-serif italic">{{ $c['tagline'] }}</span></p>
    </div>
</footer>
</body>
</html>

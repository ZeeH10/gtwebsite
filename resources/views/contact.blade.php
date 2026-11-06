@php
    $c = config('church');
    $services = \App\Models\ServiceTime::orderBy('sort')->get();
    $mapQuery = urlencode($c['address']);
@endphp
<x-layout title="Visit us" description="Service times, directions and contact details for Glad Tidings Fellowship Bethel Centre, 5 Hancock Street, North End, Gqeberha.">
<x-page-hero title="Visit us" image="gt-worship.jpg">Whether it’s your first time in church or you’re looking for a new home, there’s a seat for you at Bethel Centre.</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16">
        <div class="lg:col-span-6">
            <h2 class="h2">Every week</h2>
            <div class="mt-5">@include('partials.timetable')</div>

            <h2 class="h2 mt-14">Your first Sunday</h2>
            <ul class="mt-5 space-y-3 text-lg">
                <li class="flex gap-3"><x-glyph name="check" class="mt-1.5 text-royal-700" /> Someone will welcome you at the door and help you find a seat.</li>
                <li class="flex gap-3"><x-glyph name="check" class="mt-1.5 text-royal-700" /> Expect lively praise and worship, prayer and a message from the Word.</li>
                <li class="flex gap-3"><x-glyph name="check" class="mt-1.5 text-royal-700" /> The morning service runs from 09:00 to about 12:00.</li>
            </ul>
            <a href="{{ route('connect') }}" class="btn-navy mt-8">Let us know you’re coming</a>
        </div>

        <div class="lg:col-span-6">
            <h2 class="h2">Where to find us</h2>
            <p class="mt-4 text-lg">{{ $c['address'] }}</p>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $mapQuery }}" target="_blank" rel="noopener" class="link mt-2 inline-block">Get directions in Google Maps</a>
            <div class="mt-6">
                @include('partials.embed', ['src' => 'https://maps.google.com/maps?q='.$mapQuery.'&z=16&output=embed', 'title' => 'Map of '.$c['address'], 'label' => 'Show the map', 'icon' => 'map-pin', 'host' => 'Google Maps', 'class' => 'aspect-[4/3]'])
            </div>

            <h2 class="h2 mt-14">Get in touch</h2>
            <dl class="mt-5 divide-y divide-slate-200 border-y border-slate-200">
                <div class="flex flex-wrap justify-between gap-2 py-3"><dt class="font-semibold text-navy-900">Phone</dt>
                    <dd>@foreach ($c['phones'] as $ph)<a href="tel:+27{{ ltrim(str_replace(' ', '', $ph), '0') }}" class="link">{{ $ph }}</a>@if (! $loop->last) <span class="text-slate-400">/</span> @endif @endforeach</dd></div>
                <div class="flex flex-wrap justify-between gap-2 py-3"><dt class="font-semibold text-navy-900">WhatsApp</dt>
                    <dd><a href="https://wa.me/{{ $c['whatsapp'] }}" target="_blank" rel="noopener" class="link">Send us a message</a></dd></div>
                <div class="flex flex-wrap justify-between gap-2 py-3"><dt class="font-semibold text-navy-900">Facebook</dt>
                    <dd><a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="link">Glad Tidings Fellowship Bethel Centre</a></dd></div>
            </dl>
        </div>
    </div>
</section>
</x-layout>

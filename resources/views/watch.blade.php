@php $c = config('church'); @endphp
<x-layout title="Watch & listen" description="Sermons and services from Glad Tidings Fellowship Bethel Centre.">
<x-page-hero eyebrow="Watch & listen" title="Can’t make it on Sunday?" image="gt-pastor.jpg">Sermons and services will be streamed and uploaded here as our media ministry grows.</x-page-hero>

<section class="py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2">
        <a href="{{ $c['youtube'] ?? $c['facebook'] }}" target="_blank" rel="noopener" class="group relative block aspect-video overflow-hidden rounded-2xl bg-navy-900 shadow-2xl" data-reveal>
            <img src="{{ asset('images/gt-pastor.jpg') }}" alt="" class="size-full object-cover opacity-75 transition duration-500 group-hover:scale-105" loading="lazy" width="1024" height="765">
            <span class="absolute inset-0 bg-linear-to-t from-navy-900 via-royal-700/30 to-transparent"></span>
            <span class="absolute inset-0 grid place-items-center">
                <span class="grid size-20 place-items-center rounded-full bg-gold-500 text-navy-950 shadow-lg transition group-hover:scale-110"><x-icon name="play" class="size-8 translate-x-0.5" /></span>
            </span>
            <span class="absolute inset-x-0 bottom-0 p-5 font-display font-bold text-white">Latest message <span class="font-normal text-white/75">· coming soon</span></span>
        </a>
        <div data-reveal>
            <p class="eyebrow">Stay connected</p>
            <h2 class="h2">Follow along online</h2>
            <p class="mt-5 text-lg">Until our streams are live, join our Facebook group for updates, photos and announcements from Bethel Centre.</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="btn-navy"><x-icon name="facebook" class="size-4" /> Join our Facebook group</a>
                @if ($c['youtube'])
                    <a href="{{ $c['youtube'] }}" target="_blank" rel="noopener" class="btn-red"><x-icon name="play" class="size-4" /> YouTube channel</a>
                @endif
            </div>
        </div>
    </div>
</section>
</x-layout>

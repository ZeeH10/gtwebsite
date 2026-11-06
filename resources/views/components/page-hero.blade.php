@props(['eyebrow', 'title', 'image' => null])
{{-- Inner-page banner: royal gradient + light beams, optional faded photo --}}
<section class="bg-royal beams relative pt-18 text-white">
    @if ($image)
        <img src="{{ asset('images/'.$image) }}" alt="" class="absolute inset-0 -z-10 size-full object-cover opacity-20 mix-blend-luminosity">
    @endif
    <div class="mx-auto max-w-6xl px-4 py-16 text-center sm:px-6 sm:py-24">
        <p class="font-display text-xs font-bold tracking-[0.3em] text-gold-400 uppercase">{{ $eyebrow }}</p>
        <h1 class="mt-4 font-display text-4xl font-extrabold tracking-tight text-balance uppercase sm:text-5xl">{{ $title }}</h1>
        <div class="mt-6 flex items-center justify-center gap-3" aria-hidden="true">
            <span class="h-0.5 w-16 rounded-full bg-gradient-to-r from-transparent to-gold-500"></span>
            <x-icon name="cross" class="size-5 text-cross" stroke-width="3" />
            <span class="h-0.5 w-16 rounded-full bg-gradient-to-l from-transparent to-gold-500"></span>
        </div>
        @if ($slot->isNotEmpty())
            <p class="mx-auto mt-6 max-w-2xl text-lg text-white/85">{{ $slot }}</p>
        @endif
    </div>
</section>

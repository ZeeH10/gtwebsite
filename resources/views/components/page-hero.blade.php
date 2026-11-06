@props(['title', 'image' => null])
{{-- Inner-page banner: royal gradient + light beams; left aligned, cross mark under the title --}}
<section class="bg-royal beams relative pt-18 text-white">
    @if ($image)
        <img src="{{ asset('images/'.$image) }}" alt="" class="absolute inset-0 -z-10 size-full object-cover opacity-15 mix-blend-luminosity">
    @endif
    <div class="mx-auto max-w-6xl px-4 pt-14 pb-12 sm:px-6 sm:pt-20 sm:pb-16">
        <h1 class="display text-4xl leading-[1.05] text-white! sm:text-5xl">{{ $title }}</h1>
        <div class="mt-6 flex items-center gap-3" aria-hidden="true">
            <x-glyph name="cross" class="size-5 text-cross" stroke-width="3" />
            <span class="h-0.5 w-20 bg-gold-500"></span>
        </div>
        @if ($slot->isNotEmpty())
            <p class="prose-width mt-6 text-lg text-white/85">{{ $slot }}</p>
        @endif
    </div>
</section>

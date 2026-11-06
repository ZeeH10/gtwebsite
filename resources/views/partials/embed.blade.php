{{-- Click-to-load embed (map/video). Nothing from Google/Facebook/YouTube loads until the visitor clicks.
     Needs: $src, $title, $label. Optional: $image (background), $class (size). --}}
<button type="button" data-embed="{{ $src }}" data-title="{{ $title }}"
        class="group relative grid w-full cursor-pointer place-items-center overflow-hidden rounded-xl bg-navy-900 text-white {{ $class ?? 'aspect-video' }}">
    @isset($image)
        <img src="{{ $image }}" alt="" class="absolute inset-0 size-full object-cover opacity-50 transition-opacity group-hover:opacity-40" loading="lazy">
    @endisset
    <span class="relative flex flex-col items-center gap-3 px-6 text-center">
        <span class="grid size-16 place-items-center rounded-full bg-gold-500 text-navy-950"><x-glyph :name="$icon ?? 'play'" class="size-7" /></span>
        <span class="font-semibold">{{ $label }}</span>
        <span class="text-sm text-white/75">Loads content from {{ $host ?? 'a third party' }}. See our <span class="underline">privacy notice</span>.</span>
    </span>
</button>

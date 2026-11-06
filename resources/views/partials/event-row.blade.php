{{-- One event as a row: date block, title, when, summary. $e is an App\Models\Event --}}
<li class="flex gap-5 py-6">
    <time datetime="{{ $e->starts_on->toDateString() }}" class="flex w-16 shrink-0 flex-col items-center self-start rounded-md bg-navy-900 pt-1 pb-2 text-white">
        <span class="text-xs font-semibold text-gold-400">{{ $e->starts_on->format('M') }}</span>
        <span class="font-display text-2xl leading-none font-extrabold">{{ $e->starts_on->format('j') }}</span>
    </time>
    <div class="min-w-0">
        <h3 class="h3">{{ $e->title }}</h3>
        <p class="mt-1 text-sm text-royal-700">
            {{ $e->ends_on ? $e->starts_on->format('l j M').' to '.$e->ends_on->format('l j M Y') : $e->starts_on->format('l j F Y') }}@if ($e->time), {{ $e->time }}@endif
        </p>
        @if ($e->summary) <p class="prose-width mt-2">{{ $e->summary }}</p> @endif
        @if ($e->image && $e->image_is_poster)
            <a href="{{ $e->image_url }}" target="_blank" rel="noopener" class="link mt-2 inline-block text-sm">View the poster</a>
        @endif
    </div>
</li>

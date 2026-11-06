@php
    $d = \Illuminate\Support\Carbon::parse($e['date']);
    $end = isset($e['end']) ? \Illuminate\Support\Carbon::parse($e['end']) : null;
    $past = ($end ?? $d)->endOfDay()->isPast();
@endphp
<li class="card flex flex-col" data-reveal>
    <div class="relative">
        <img src="{{ asset('images/'.$e['image']) }}" alt="{{ !empty($e['poster']) ? $e['name'].' poster' : '' }}" class="aspect-[16/10] w-full object-cover {{ !empty($e['poster']) ? 'object-top' : '' }}" loading="lazy" width="1024" height="640">
        <span class="absolute top-3 left-3 rounded-full px-3 py-1 font-display text-xs font-bold tracking-wider uppercase {{ $past ? 'bg-white/90 text-navy-900' : 'bg-cross text-white' }}">{{ $past ? 'Past event' : 'Upcoming' }}</span>
    </div>
    <div class="flex flex-1 gap-5 p-6">
        <time datetime="{{ $e['date'] }}" class="flex w-14 shrink-0 flex-col items-center self-start overflow-hidden rounded-lg bg-navy-900 pb-2 text-white">
            <span class="w-full bg-cross py-0.5 text-center font-display text-xs font-bold tracking-wider uppercase">{{ $d->format('M') }}</span>
            <span class="mt-1 font-display text-2xl font-extrabold">{{ $d->format('j') }}</span>
        </time>
        <div>
            <h3 class="font-display text-lg font-bold text-navy-900">{{ $e['name'] }}</h3>
            <p class="mt-1 flex items-center gap-1.5 text-sm text-royal-700"><x-icon name="clock" class="size-4" />
                {{ $end ? $d->format('j M').' – '.$end->format('j M Y') : $d->format('l') }} · {{ $e['time'] }}</p>
            <p class="mt-2 text-slate-600">{{ $e['text'] }}</p>
            @if (!empty($e['poster']))
                <a href="{{ asset('images/'.$e['image']) }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-1 font-semibold text-royal-700 hover:underline">View poster <x-icon name="arrow-right" class="size-4" /></a>
            @endif
        </div>
    </div>
</li>

@php
    [$upcoming, $past] = collect(config('church.events'))
        ->partition(fn ($e) => \Illuminate\Support\Carbon::parse($e['end'] ?? $e['date'])->endOfDay()->isFuture());
    $upcoming = $upcoming->sortBy('date');
    $past = $past->sortByDesc('date');
@endphp
<x-layout title="Events" description="Upcoming services, conferences and events at Glad Tidings Fellowship Bethel Centre, Gqeberha.">
<x-page-hero eyebrow="Events" title="Gather with us" image="gt-choir.jpg">Conferences, special services and church family moments at Bethel Centre.</x-page-hero>

<section class="py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <p class="eyebrow">Upcoming</p>
        <h2 class="h2">What’s coming up</h2>
        @if ($upcoming->isEmpty())
            <p class="mt-6 text-lg">New events will be announced soon. Follow our Facebook group for updates.</p>
        @else
            <ul class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($upcoming as $e) @include('partials.event-card') @endforeach
            </ul>
        @endif
    </div>
</section>

@if ($past->isNotEmpty())
<section class="bg-mist py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <p class="eyebrow">Recently</p>
        <h2 class="h2">Past events</h2>
        <ul class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ($past as $e) @include('partials.event-card') @endforeach
        </ul>
    </div>
</section>
@endif
</x-layout>

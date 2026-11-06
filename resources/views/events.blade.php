@php
    use App\Models\Event;
    $upcoming = Event::upcoming()->get();
    $past = Event::past()->take(12)->get();
@endphp
<x-layout title="Events" description="Upcoming services, conferences and events at Glad Tidings Fellowship Bethel Centre, Gqeberha.">
<x-page-hero title="Events" image="gt-choir.jpg">Conferences, special services and church family moments at Bethel Centre.</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="h2">Coming up</h2>
        @if ($upcoming->isEmpty())
            <p class="mt-5 text-lg">New events will be announced soon. Follow our <a href="{{ config('church.facebook') }}" class="link" target="_blank" rel="noopener">Facebook page</a> for updates.</p>
        @else
            <ul class="mt-4 divide-y divide-slate-200">
                @foreach ($upcoming as $e) @include('partials.event-row') @endforeach
            </ul>
        @endif
    </div>
</section>

@if ($past->isNotEmpty())
<section class="bg-mist py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="h2">Recently</h2>
        <ul class="mt-8 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($past as $e)
                <li>
                    @if ($e->image_url)
                        <a href="{{ $e->image_url }}" target="_blank" rel="noopener" class="block">
                            <img src="{{ $e->image_url }}" alt="{{ $e->image_is_poster ? $e->title.' poster' : '' }}" class="aspect-[4/5] w-full rounded-xl object-cover object-top" loading="lazy">
                        </a>
                    @endif
                    <h3 class="h3 mt-4">{{ $e->title }}</h3>
                    <p class="text-sm text-royal-700">{{ $e->starts_on->format('j F Y') }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>
@endif
</x-layout>

@php
    use App\Models\{HomeGroup, Ministry};
    $c = config('church');
    $ministries = Ministry::where('is_published', true)->orderBy('sort')->get();
    $groups = HomeGroup::where('is_active', true)->orderBy('area')->get(['area', 'meeting_day', 'meeting_time']);
@endphp
<x-layout title="Ministries and home groups" description="Ministries and Tuesday home groups at Glad Tidings Fellowship Bethel Centre, Gqeberha.">
<x-page-hero title="Find your place" image="gt-youth.jpg">Ministry is expressed through genuine service. Here’s where people at Bethel Centre serve and grow.</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="h2">Serving teams</h2>
        <ul class="mt-8 grid gap-x-12 border-t border-slate-200 md:grid-cols-2">
            @foreach ($ministries as $m)
                <li class="border-b border-slate-200 py-5">
                    <h3 class="h3">{{ $m->name }}</h3>
                    <p class="prose-width mt-1.5">{{ $m->summary }}</p>
                </li>
            @endforeach
        </ul>
        <p class="mt-8 text-lg">Want to serve on a team? <a href="{{ route('connect') }}" class="link">Let us know on a connect card</a>.</p>
    </div>
</section>

<section id="home-groups" class="bg-mist py-20 sm:py-24">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-12">
        <div class="lg:col-span-6">
            <h2 class="h2">Home groups</h2>
            <p class="prose-width mt-5 text-lg">Small groups meet in homes across Gqeberha to study the Bible, pray for one another and do life together. It’s the easiest way to get to know people at Bethel Centre.</p>
            @if ($groups->isNotEmpty())
                <table class="mt-8 w-full text-left">
                    <caption class="sr-only">Home groups by area</caption>
                    <thead class="text-sm text-slate-500"><tr><th class="pb-2 font-medium">Area</th><th class="pb-2 font-medium">Meets</th></tr></thead>
                    <tbody class="divide-y divide-slate-200 border-y border-slate-200">
                        @foreach ($groups as $g)
                            <tr><td class="py-3 font-semibold text-navy-900">{{ $g->area }}</td><td class="py-3">{{ $g->meeting_day }} {{ $g->meeting_time }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('connect') }}" class="btn-navy">Ask to join a group</a>
                <a href="https://wa.me/{{ $c['whatsapp'] }}?text={{ urlencode('Hi! I’d like to join a home group near me.') }}" target="_blank" rel="noopener" class="link self-center">or WhatsApp us</a>
            </div>
        </div>
        <img src="{{ asset('images/gt-homegroup.jpg') }}" alt="Church members at a home group Bible study" class="aspect-[4/3] w-full rounded-xl object-cover lg:col-span-6" loading="lazy" width="1024" height="765">
    </div>
</section>
</x-layout>

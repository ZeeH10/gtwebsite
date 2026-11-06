@php
    use App\Models\{Sermon, Setting};
    $c = config('church');
    $sermons = Sermon::where('is_published', true)->orderByDesc('preached_on')->take(10)->get();
    $latest = $sermons->shift();
    $youtube = Setting::get('youtube');
@endphp
<x-layout title="Watch" description="Watch services and messages from Glad Tidings Fellowship Bethel Centre live on Facebook.">
<x-page-hero title="Watch and listen" image="gt-pastor.jpg">Services and conferences are streamed live on our Facebook page.</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-12">
        <div class="lg:col-span-7">
            @if ($latest)
                @include('partials.embed', ['src' => $latest->embed_url, 'title' => $latest->title, 'label' => 'Play: '.$latest->title, 'image' => asset('images/gt-pastor.jpg'), 'host' => str_contains($latest->embed_url, 'youtube') ? 'YouTube' : 'Facebook'])
                <h2 class="h3 mt-4">{{ $latest->title }}</h2>
                <p class="text-sm text-royal-700">{{ $latest->preacher }}@if ($latest->preacher), @endif{{ $latest->preached_on->format('j F Y') }}</p>
            @else
                <a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="group relative grid aspect-video place-items-center overflow-hidden rounded-xl bg-navy-900 text-white">
                    <img src="{{ asset('images/gt-pastor.jpg') }}" alt="" class="absolute inset-0 size-full object-cover opacity-50 transition-opacity group-hover:opacity-40" loading="lazy">
                    <span class="relative flex flex-col items-center gap-3">
                        <span class="grid size-16 place-items-center rounded-full bg-gold-500 text-navy-950"><x-glyph name="play" class="size-7" /></span>
                        <span class="font-semibold">Watch on our Facebook page</span>
                    </span>
                </a>
            @endif
        </div>
        <div class="lg:col-span-5">
            <h2 class="h2">Watch live</h2>
            <p class="mt-4 text-lg">Follow our Facebook page to be notified when a service or conference goes live.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="btn-navy"><x-glyph name="facebook" class="size-4" /> Open our Facebook page</a>
                @if ($youtube) <a href="{{ $youtube }}" target="_blank" rel="noopener" class="link self-center">YouTube channel</a> @endif
            </div>

            @if ($sermons->isNotEmpty())
                <h2 class="h2 mt-12">Earlier messages</h2>
                <ul class="mt-4 divide-y divide-slate-200 border-y border-slate-200">
                    @foreach ($sermons as $s)
                        <li class="py-4">
                            <a href="{{ $s->video_url }}" target="_blank" rel="noopener" class="font-semibold text-navy-900 hover:text-royal-700">{{ $s->title }}</a>
                            <p class="text-sm text-slate-600">{{ $s->preacher }}@if ($s->preacher), @endif{{ $s->preached_on->format('j M Y') }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
</x-layout>

@php $c = config('church'); @endphp
<x-layout title="About us" description="Our story, vision, beliefs and pastor at Glad Tidings Fellowship Bethel Centre, Gqeberha.">
<x-page-hero eyebrow="About us" title="Who we are" image="gt-worship.jpg">{{ $c['welcome'] }}</x-page-hero>

{{-- STORY --}}
<section class="py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16">
        <div data-reveal>
            <p class="eyebrow">Our story</p>
            <h2 class="h2">“Go ye therefore…” We are going.</h2>
            @foreach ($c['story'] as $p)
                <p class="mt-5 text-lg leading-relaxed">{{ $p }}</p>
            @endforeach
            <a href="{{ $c['family_url'] }}" target="_blank" rel="noopener" class="mt-8 inline-flex items-center gap-1 font-display font-bold text-royal-700 hover:underline">Visit the wider Glad Tidings family <x-icon name="arrow-right" class="size-4" /></a>
        </div>
        <img src="{{ asset('images/gt-choir.jpg') }}" alt="The Bethel Centre choir in worship" class="aspect-[4/3] w-full rounded-2xl object-cover shadow-xl" loading="lazy" width="1280" height="956" data-reveal>
    </div>
</section>

{{-- VISION / MISSION / VALUES --}}
<section class="bg-mist py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="bg-navy-900 rounded-3xl p-8 text-white shadow-xl sm:p-10" data-reveal>
                <p class="eyebrow eyebrow-light">Our vision</p>
                <p class="mt-4 font-display text-2xl leading-snug font-bold text-balance sm:text-3xl">{{ $c['vision'] }}</p>
            </div>
            <div class="card p-8 sm:p-10" data-reveal>
                <p class="eyebrow">Our mission</p>
                <p class="mt-4 text-lg leading-relaxed">To pursue and fulfil the divine mandate of the Great Commission: <em class="font-serif">“Go ye therefore, and teach all nations, baptizing them in the name of the Father, and of the Son, and of the Holy Ghost.”</em></p>
                <p class="mt-4"><span class="brush text-xs tracking-[0.2em] uppercase">Matthew 28:19</span></p>
            </div>
        </div>
        <ul class="mt-6 grid gap-6 sm:grid-cols-3">
            @foreach ([
                ['Christ-centred', 'book', 'Jesus is at the centre of our worship, teaching and life together.'],
                ['Family-oriented', 'users', 'We are a church family where every generation belongs.'],
                ['Equipped to serve', 'hand-heart', 'Ministry is expressed through genuine service. Everyone has a part.'],
            ] as [$v, $icon, $t])
                <li class="card p-6" data-reveal>
                    <span class="grid size-12 place-items-center rounded-xl bg-royal-700 text-gold-400"><x-icon :name="$icon" class="size-6" /></span>
                    <h3 class="mt-4 font-display text-lg font-bold text-navy-900">{{ $v }}</h3>
                    <p class="mt-2 text-slate-600">{{ $t }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- PASTOR --}}
<section class="py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-5">
        <div class="lg:col-span-2" data-reveal>
            <div class="bg-navy-900 mx-auto max-w-sm rounded-3xl p-3 shadow-2xl">
                <img src="{{ asset('images/'.$c['pastor']['image']) }}" alt="{{ $c['pastor']['name'] }}" class="aspect-square w-full rounded-2xl object-cover" width="350" height="350" loading="lazy">
                <div class="px-3 py-4 text-center text-white">
                    <p class="font-display text-lg font-bold">{{ $c['pastor']['name'] }}</p>
                    <p class="text-sm text-gold-300">{{ $c['pastor']['title'] }}</p>
                </div>
            </div>
        </div>
        <div class="lg:col-span-3" data-reveal>
            <p class="eyebrow">Our pastor</p>
            <h2 class="h2">Meet {{ $c['pastor']['name'] }}</h2>
            @foreach ($c['pastor']['bio'] as $p)
                <p class="mt-5 text-lg leading-relaxed">{{ $p }}</p>
            @endforeach
        </div>
    </div>
</section>

{{-- BELIEFS --}}
<section class="bg-mist py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl" data-reveal>
            <p class="eyebrow">What we believe</p>
            <h2 class="h2">Built on the Word of God</h2>
        </div>
        <ul class="mt-12 grid gap-6 sm:grid-cols-2">
            @foreach ($c['beliefs'] as $b)
                <li class="card flex gap-5 p-6" data-reveal>
                    <x-icon name="cross" class="size-7 text-cross" stroke-width="2.5" />
                    <div>
                        <h3 class="font-display text-lg font-bold text-navy-900">{{ $b['title'] }}</h3>
                        <p class="mt-1 text-slate-600">{{ $b['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

@include('partials.scripture', ['verse' => 'Go ye therefore, and teach all nations, baptizing them in the name of the Father, and of the Son, and of the Holy Ghost.', 'ref' => 'Matthew 28:19'])
</x-layout>

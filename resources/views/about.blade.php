@php use App\Models\Setting; $c = config('church'); @endphp
<x-layout title="About us" description="Our story, vision, beliefs and pastor at Glad Tidings Fellowship Bethel Centre, Gqeberha.">
<x-page-hero title="Who we are" image="gt-worship.jpg">{{ $c['welcome'] }}</x-page-hero>

<section class="py-20 sm:py-24">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16">
        <div class="lg:col-span-7">
            <h2 class="h2">Our story</h2>
            @foreach (Setting::paragraphs('story') as $p)
                <p class="prose-width mt-5 text-lg">{{ $p }}</p>
            @endforeach
            <p class="mt-5"><a href="{{ $c['family_url'] }}" target="_blank" rel="noopener" class="link">The wider Glad Tidings Fellowship family</a></p>

            <h2 class="h2 mt-14">Vision</h2>
            <p class="prose-width mt-4 font-display text-xl leading-snug font-semibold text-navy-900">{{ $c['vision'] }}</p>

            <h2 class="h2 mt-14">Mission</h2>
            <p class="prose-width mt-4 text-lg">To pursue and fulfil the Great Commission: <em class="font-serif">“Go ye therefore, and teach all nations, baptizing them in the name of the Father, and of the Son, and of the Holy Ghost.”</em> Our response is simple: we are going.</p>
            <p class="mt-4"><span class="brush">Matthew 28:19</span></p>
        </div>

        <aside class="lg:col-span-5">
            <h2 class="h2">What we value</h2>
            <dl class="mt-5 divide-y divide-slate-200 border-y border-slate-200">
                @foreach ([
                    'Christ-centred' => 'Jesus is at the centre of our worship, teaching and life together.',
                    'Family-oriented' => 'Every generation belongs here, from Sunday school to the elders.',
                    'Equipped to serve' => 'Ministry is expressed through genuine service. Everyone has a part.',
                ] as $v => $t)
                    <div class="py-5">
                        <dt class="h3">{{ $v }}</dt>
                        <dd class="mt-1">{{ $t }}</dd>
                    </div>
                @endforeach
            </dl>
        </aside>
    </div>
</section>

<section class="bg-mist py-20 sm:py-24">
    <div class="mx-auto grid max-w-6xl items-start gap-12 px-4 sm:px-6 md:grid-cols-12">
        <img src="{{ asset('images/'.$c['pastor']['image']) }}" alt="{{ Setting::get('pastor_name') }}" class="aspect-square w-full max-w-sm rounded-xl bg-royal object-cover md:col-span-4" width="350" height="350" loading="lazy">
        <div class="md:col-span-8">
            <h2 class="h2">{{ Setting::get('pastor_name') }}</h2>
            <p class="mt-1 text-royal-700">{{ Setting::get('pastor_title') }}</p>
            @foreach (Setting::paragraphs('pastor_bio') as $p)
                <p class="prose-width mt-5 text-lg">{{ $p }}</p>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 sm:py-24">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="h2">What we believe</h2>
        <dl class="mt-8 grid gap-x-12 gap-y-8 md:grid-cols-2">
            @foreach ($c['beliefs'] as $b)
                <div class="flex gap-4">
                    <x-glyph name="cross" class="mt-1 size-5 text-cross" stroke-width="3" />
                    <div>
                        <dt class="h3">{{ $b['title'] }}</dt>
                        <dd class="mt-1">{{ $b['text'] }}</dd>
                    </div>
                </div>
            @endforeach
        </dl>
    </div>
</section>

@include('partials.connect-band')
</x-layout>

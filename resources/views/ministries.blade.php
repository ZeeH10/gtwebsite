@php $c = config('church'); @endphp
<x-layout title="Ministries" description="Ministries at Glad Tidings Fellowship Bethel Centre: worship, home groups, youth & campus, children, prayer and outreach.">
<x-page-hero eyebrow="Ministries" title="Belong. Grow. Serve." image="gt-youth.jpg">Ministry is expressed through genuine service. Find where you fit at Bethel Centre.</x-page-hero>

<section class="py-20 sm:py-28">
    <ul class="mx-auto grid max-w-6xl gap-6 px-4 sm:grid-cols-2 sm:px-6 lg:grid-cols-3">
        @foreach ($c['ministries'] as $m)
            @include('partials.ministry-card')
        @endforeach
    </ul>
</section>

{{-- HOME GROUPS --}}
<section class="bg-mist py-20 sm:py-24">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2">
        <img src="{{ asset('images/gt-homegroup.jpg') }}" alt="Church members at a home group Bible study" class="aspect-[4/3] w-full rounded-2xl object-cover shadow-xl lg:order-2" loading="lazy" width="1024" height="765" data-reveal>
        <div data-reveal>
            <p class="eyebrow">Home groups · Tuesdays 18:00</p>
            <h2 class="h2">Church is better around a table</h2>
            <p class="mt-5 text-lg">Our home groups meet across Gqeberha every Tuesday evening to study the Bible, pray for one another and do life together. It’s the easiest way to get to know people at Bethel Centre.</p>
            <a href="https://wa.me/{{ $c['whatsapp'] }}?text={{ urlencode('Hi! I’d like to join a home group near me.') }}" target="_blank" rel="noopener" class="btn-navy mt-8"><x-icon name="message" class="size-4" /> Find a group near you</a>
        </div>
    </div>
</section>
</x-layout>

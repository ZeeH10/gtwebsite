@php $c = config('church'); $mapQuery = urlencode($c['address']); @endphp
<x-layout title="Visit & contact" description="Service times, directions and contact details for Glad Tidings Fellowship Bethel Centre, 5 Hancock Street, North End, Gqeberha.">
<x-page-hero eyebrow="Plan your visit" title="Join us this week" image="gt-worship.jpg">Whether it’s your first time in church or you’re looking for a new home, there’s a seat for you at Bethel Centre.</x-page-hero>

{{-- SERVICE TIMES + WHAT TO EXPECT --}}
<section class="py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl gap-6 px-4 sm:px-6 lg:grid-cols-5">
        <ul class="grid gap-4 sm:grid-cols-3 lg:col-span-3 lg:grid-cols-1" data-reveal>
            @foreach ($c['services'] as $s)
                <li class="card flex items-center gap-5 p-6">
                    <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-royal-700 text-gold-400 shadow-lg"><x-icon :name="$s['icon']" class="size-6" /></span>
                    <div>
                        <p class="font-display text-xs font-bold tracking-widest text-cross uppercase">{{ $s['day'] }}</p>
                        <p class="font-display text-lg font-bold text-navy-900">{{ $s['name'] }}</p>
                        <p class="flex items-center gap-1.5 text-slate-600"><x-icon name="clock" class="size-4" /> {{ $s['time'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="bg-navy-900 flex flex-col rounded-3xl p-8 text-white shadow-xl lg:col-span-2" data-reveal>
            <h2 class="font-display text-xl font-bold">What to expect</h2>
            <ul class="mt-5 space-y-3 text-white/90">
                @foreach (['A warm welcome at the door', 'Lively praise and worship', 'Prayer and a message from the Word', 'Children’s church for the little ones'] as $item)
                    <li class="flex gap-3"><x-icon name="check" class="mt-0.5 text-gold-400" /> {{ $item }}</li>
                @endforeach
            </ul>
            <div class="mt-auto flex flex-wrap gap-3 pt-8">
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $mapQuery }}" target="_blank" rel="noopener" class="btn-gold">Get directions</a>
                <a href="https://wa.me/{{ $c['whatsapp'] }}?text={{ urlencode('Hi! I’d like to visit Glad Tidings Bethel Centre this Sunday.') }}" target="_blank" rel="noopener" class="btn-outline">WhatsApp us</a>
            </div>
        </div>
    </div>
</section>

{{-- CONTACT + MAP --}}
<section class="bg-mist py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl" data-reveal>
            <p class="eyebrow">Contact</p>
            <h2 class="h2">We’d love to hear from you</h2>
        </div>
        <div class="mt-12 grid gap-6 lg:grid-cols-5">
            <ul class="grid gap-4 sm:grid-cols-2 lg:col-span-2 lg:grid-cols-1" data-reveal>
                <li class="card flex gap-4 p-6">
                    <x-icon name="map-pin" class="size-6 text-royal-600" />
                    <div><p class="font-display font-bold text-navy-900">Visit us</p><p class="mt-1">{{ $c['address'] }}</p></div>
                </li>
                <li class="card flex gap-4 p-6">
                    <x-icon name="phone" class="size-6 text-royal-600" />
                    <div>
                        <p class="font-display font-bold text-navy-900">Call us</p>
                        @foreach ($c['phones'] as $ph)
                            <a href="tel:+27{{ ltrim(str_replace(' ', '', $ph), '0') }}" class="mt-1 block text-royal-700 hover:underline">{{ $ph }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="card flex gap-4 p-6">
                    <x-icon name="message" class="size-6 text-royal-600" />
                    <div><p class="font-display font-bold text-navy-900">WhatsApp</p><a href="https://wa.me/{{ $c['whatsapp'] }}" target="_blank" rel="noopener" class="mt-1 block text-royal-700 hover:underline">Send us a message</a></div>
                </li>
                <li class="card flex gap-4 p-6">
                    <x-icon name="facebook" class="size-6 text-royal-600" />
                    <div><p class="font-display font-bold text-navy-900">Facebook</p><a href="{{ $c['facebook'] }}" target="_blank" rel="noopener" class="mt-1 block text-royal-700 hover:underline">facebook.com/groups/gtfec</a></div>
                </li>
            </ul>
            <iframe title="Map showing {{ $c['address'] }}" src="https://maps.google.com/maps?q={{ $mapQuery }}&z=16&output=embed" class="min-h-80 w-full rounded-2xl border-0 shadow-sm ring-1 ring-slate-200 lg:col-span-3" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
</x-layout>

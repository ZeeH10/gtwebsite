@php $c = config('church'); $g = $c['giving']; @endphp
<x-layout title="Give" description="Give to Glad Tidings Fellowship Bethel Centre: tithes, offerings, Pastor's Appreciation, funeral contributions, conference and weddings.">
<x-page-hero eyebrow="Give" title="Partner with the ministry">Your giving supports the church, its pastors and members in every season of life.</x-page-hero>

<section class="py-20 sm:py-28">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center">
        <div data-reveal>
            <p class="eyebrow">Ways to give</p>
            <h2 class="h2">Give by EFT or in person</h2>
            <p class="mt-5 text-lg">You can give by EFT using the banking details here, or in person at any service. Please use the reference shown so your gift goes to the right place.</p>
            <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                @foreach ($g['purposes'] as $p)
                    <li class="flex items-center gap-3 rounded-xl bg-mist px-4 py-3 font-semibold text-navy-900"><x-icon name="check" class="text-cross" /> {{ $p }}</li>
                @endforeach
            </ul>
        </div>
        <div class="bg-navy-900 rounded-3xl p-8 text-white shadow-2xl sm:p-10" data-reveal>
            <h3 class="flex items-center gap-3 font-display text-xl font-bold"><x-icon name="hand-heart" class="size-6 text-gold-400" /> Banking details</h3>
            <dl class="mt-6 divide-y divide-white/15">
                @foreach (['Bank' => $g['bank'], 'Account name' => $g['account_name'], 'Account number' => $g['account_number'], 'Branch code' => $g['branch_code']] as $k => $v)
                    <div class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-3">
                        <dt class="text-white/70">{{ $k }}</dt>
                        <dd class="font-semibold">{{ $v }}</dd>
                    </div>
                @endforeach
            </dl>
            <p class="mt-6 rounded-xl bg-white/10 p-4 text-sm text-white/90">Reference: <strong class="text-gold-300">your name + purpose</strong>, e.g. “T Moyo Tithe” or “T Moyo Funeral”.</p>
        </div>
    </div>
</section>

@include('partials.scripture', ['verse' => 'Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver.', 'ref' => '2 Corinthians 9:7'])
</x-layout>

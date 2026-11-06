@php use App\Models\Setting; $g = config('church.giving'); @endphp
<x-layout title="Give" description="Give to Glad Tidings Fellowship Bethel Centre by EFT: tithes, offerings, Pastor’s Appreciation, funeral contributions, conference and weddings.">
<x-page-hero title="Give">Your giving supports the church, its pastors and members in every season of life.</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-12">
        <div class="lg:col-span-6">
            <h2 class="h2">Give by EFT or in person</h2>
            <p class="prose-width mt-4 text-lg">Give at any service, or by EFT to the account here. Use your name and what the gift is for as the reference, so it reaches the right place.</p>
            <h3 class="h3 mt-10">You can give towards</h3>
            <ul class="mt-3 divide-y divide-slate-200 border-y border-slate-200">
                @foreach ($g['purposes'] as $p)
                    <li class="flex items-center gap-3 py-3 font-medium text-navy-900"><x-glyph name="cross" class="size-4 text-cross" stroke-width="3" /> {{ $p }}</li>
                @endforeach
            </ul>
        </div>
        <div class="lg:col-span-6">
            <div class="rounded-xl bg-navy-900 p-8 text-white sm:p-10">
                <h2 class="font-display text-xl font-semibold">Banking details</h2>
                <dl class="mt-6 divide-y divide-white/15">
                    @foreach (['Bank' => 'bank', 'Account name' => 'account_name', 'Account number' => 'account_number', 'Branch code' => 'branch_code'] as $label => $key)
                        <div class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-3">
                            <dt class="text-white/70">{{ $label }}</dt>
                            <dd class="font-semibold tabular-nums">{{ Setting::get($key) }}</dd>
                        </div>
                    @endforeach
                </dl>
                <p class="mt-6 border-t border-white/15 pt-5 text-white/85">Reference: <strong class="text-gold-300">your name and purpose</strong>, for example “T Moyo Tithe” or “T Moyo Funeral”.</p>
            </div>
        </div>
    </div>
</section>

@include('partials.scripture', ['verse' => 'Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver.', 'ref' => '2 Corinthians 9:7'])
</x-layout>

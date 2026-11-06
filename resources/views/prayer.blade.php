@php $c = config('church'); @endphp
<x-layout title="Prayer request" description="Send a prayer request to the pastors and prayer team at Glad Tidings Fellowship Bethel Centre.">
<x-page-hero eyebrow="Prayer requests" title="How can we pray for you?" image="gt-prayer.jpg">Every request is read and prayed over by our pastors and prayer team. You’re also welcome at our Friday prayer meeting, 18:00.</x-page-hero>

<section class="px-4 py-20 sm:px-6 sm:py-28">
    <div class="mx-auto grid max-w-6xl overflow-hidden rounded-3xl shadow-2xl ring-1 ring-slate-200 lg:grid-cols-5">
        <div class="bg-navy-900 relative flex flex-col justify-end p-8 text-white sm:p-10 lg:col-span-2">
            <img src="{{ asset('images/gt-prayer.jpg') }}" alt="" class="absolute inset-0 -z-10 size-full object-cover opacity-35 mix-blend-luminosity" loading="lazy">
            <x-icon name="cross" class="size-8 text-cross" stroke-width="3" />
            <blockquote class="mt-6 font-serif text-xl text-white/95 italic">“If two of you shall agree on earth as touching any thing that they shall ask, it shall be done for them of my Father which is in heaven.”</blockquote>
            <p class="mt-5"><span class="brush text-xs tracking-[0.2em] uppercase">Matthew 18:19</span></p>
        </div>

        <div class="bg-white p-8 sm:p-10 lg:col-span-3">
            @if (session('prayer_sent'))
                <div role="status" class="flex gap-4 rounded-xl bg-emerald-50 p-6 text-emerald-900 ring-1 ring-emerald-200">
                    <x-icon name="check" class="size-6 text-emerald-600" />
                    <div>
                        <p class="font-display font-bold">Thank you, your request has been received.</p>
                        <p class="mt-1">Our prayer team will be standing with you. If you left contact details, someone may reach out.</p>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('prayer.store') }}" class="space-y-5" novalidate>
                    @csrf
                    <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="font-semibold text-navy-900">Name <span class="font-normal text-slate-500">(optional)</span></label>
                            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" class="field" maxlength="100">
                        </div>
                        <div>
                            <label for="contact" class="font-semibold text-navy-900">Phone or email <span class="font-normal text-slate-500">(optional)</span></label>
                            <input id="contact" name="contact" type="text" autocomplete="email" value="{{ old('contact') }}" class="field" maxlength="150">
                        </div>
                    </div>
                    <div>
                        <label for="request" class="font-semibold text-navy-900">Your prayer request <span class="text-cross" aria-hidden="true">*</span></label>
                        <textarea id="request" name="request" rows="6" required maxlength="3000" class="field @error('request') border-cross! @enderror" @error('request') aria-invalid="true" aria-describedby="request-error" @enderror>{{ old('request') }}</textarea>
                        @error('request') <p id="request-error" class="mt-1.5 text-sm text-cross-600">{{ $message }}</p> @enderror
                    </div>
                    <label class="flex cursor-pointer items-start gap-3">
                        <input type="checkbox" name="pastors_only" value="1" @checked(old('pastors_only')) class="mt-1 size-5 rounded border-slate-300 accent-royal-700">
                        <span>Keep this confidential: share with the pastors only</span>
                    </label>
                    <button type="submit" class="btn-navy w-full sm:w-auto">Send prayer request</button>
                </form>
            @endif
        </div>
    </div>
</section>
</x-layout>

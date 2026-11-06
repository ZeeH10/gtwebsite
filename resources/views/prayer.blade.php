<x-layout title="Ask for prayer" description="Send a prayer request to the pastors and prayer team at Glad Tidings Fellowship Bethel Centre.">
<x-page-hero title="How can we pray for you?" image="gt-prayer.jpg">Every request is read and prayed over by our pastors and prayer team. You’re also welcome at our Friday prayer meeting at 18:00.</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-12">
        <div class="lg:col-span-7">
            @if (session('prayer_sent'))
                <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 p-6 text-emerald-900">
                    <p class="h3 text-emerald-900!">Prayer request sent</p>
                    <p class="mt-1">Our prayer team will be standing with you. If you left contact details, someone may reach out.</p>
                    <a href="{{ route('prayer') }}" class="link mt-3 inline-block">Send another request</a>
                </div>
            @else
                <form method="POST" action="{{ route('prayer.store') }}" class="space-y-6" novalidate>
                    @csrf
                    <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                    <div>
                        <label for="request" class="label">Your prayer request</label>
                        <textarea id="request" name="request" rows="7" required maxlength="3000" class="field @error('request') border-cross! @enderror" @error('request') aria-invalid="true" aria-describedby="request-error" @enderror>{{ old('request') }}</textarea>
                        @error('request') <p id="request-error" class="mt-1.5 text-sm text-cross-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="label">Name <span class="font-normal text-slate-500">(optional)</span></label>
                            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" class="field" maxlength="100">
                        </div>
                        <div>
                            <label for="contact" class="label">Phone or email <span class="font-normal text-slate-500">(optional)</span></label>
                            <input id="contact" name="contact" type="text" autocomplete="email" value="{{ old('contact') }}" class="field" maxlength="150">
                        </div>
                    </div>
                    <label class="flex cursor-pointer items-start gap-3">
                        <input type="checkbox" name="pastors_only" value="1" @checked(old('pastors_only')) class="mt-1 size-5 shrink-0 rounded border-slate-300 accent-royal-700">
                        <span>Keep this confidential: only the pastors may read it</span>
                    </label>
                    @include('partials.consent', ['purpose' => 'pray for me and, if I left contact details, follow up'])
                    <button type="submit" class="btn-navy">Send prayer request</button>
                </form>
            @endif
        </div>
        <figure class="lg:col-span-5">
            <blockquote class="font-serif text-2xl leading-relaxed text-navy-900 italic">“If two of you shall agree on earth as touching any thing that they shall ask, it shall be done for them of my Father which is in heaven.”</blockquote>
            <figcaption class="mt-4"><span class="brush">Matthew 18:19</span></figcaption>
        </figure>
    </div>
</section>
</x-layout>

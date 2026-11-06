@php use App\Models\ConnectCard; @endphp
<x-layout title="I’m new here" description="New to Glad Tidings Fellowship Bethel Centre? Fill in a connect card and we’ll be in touch.">
<x-page-hero title="We’re glad you’re here" image="gt-worship.jpg">Tell us a little about yourself and someone from Bethel Centre will get in touch. Only your name is required.</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        @if (session('connect_sent'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 p-6 text-emerald-900">
                <p class="h3 text-emerald-900!">Connect card sent</p>
                <p class="mt-1">Thank you! Someone from the church will contact you soon. We look forward to seeing you on Sunday.</p>
            </div>
        @else
            <form method="POST" action="{{ route('connect.store') }}" class="space-y-6" novalidate>
                @csrf
                <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

                <div>
                    <label for="name" class="label">Your name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required maxlength="100" value="{{ old('name') }}" class="field @error('name') border-cross! @enderror" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                    @error('name') <p id="name-error" class="mt-1.5 text-sm text-cross-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="label">Phone or WhatsApp</label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" maxlength="30" value="{{ old('phone') }}" class="field">
                    </div>
                    <div>
                        <label for="email" class="label">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" maxlength="150" value="{{ old('email') }}" class="field @error('email') border-cross! @enderror" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email') <p id="email-error" class="mt-1.5 text-sm text-cross-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="area" class="label">Area you live in</label>
                        <input id="area" name="area" type="text" maxlength="100" placeholder="e.g. Walmer, Summerstrand" value="{{ old('area') }}" class="field">
                    </div>
                    <div>
                        <label for="visited_on" class="label">When did you first visit?</label>
                        <input id="visited_on" name="visited_on" type="date" max="{{ today()->toDateString() }}" value="{{ old('visited_on') }}" class="field">
                    </div>
                </div>
                <div>
                    <label for="how_heard" class="label">How did you hear about us?</label>
                    <select id="how_heard" name="how_heard" class="field">
                        <option value="">Choose one</option>
                        @foreach (['A friend or family member', 'Facebook', 'Walked past the church', 'Google search', 'Other'] as $opt)
                            <option @selected(old('how_heard') === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <fieldset>
                    <legend class="label">I’d like to know more about</legend>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        @foreach (ConnectCard::INTERESTS as $key => $label)
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="checkbox" name="interests[]" value="{{ $key }}" @checked(in_array($key, old('interests', []))) class="size-5 rounded border-slate-300 accent-royal-700">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
                <div>
                    <label for="message" class="label">Anything else you’d like us to know? <span class="font-normal text-slate-500">(optional)</span></label>
                    <textarea id="message" name="message" rows="4" maxlength="2000" class="field">{{ old('message') }}</textarea>
                </div>
                @include('partials.consent', ['purpose' => 'contact me and help me get connected at church'])
                <button type="submit" class="btn-navy">Send connect card</button>
            </form>
        @endif
    </div>
</section>
</x-layout>

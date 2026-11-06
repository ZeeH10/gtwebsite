<x-layout title="Page not found">
<x-page-hero title="We couldn’t find that page">The link may be old or mistyped. Here are some places to go instead.</x-page-hero>
<section class="py-16">
    <div class="mx-auto flex max-w-6xl flex-wrap gap-3 px-4 sm:px-6">
        <a href="{{ route('home') }}" class="btn-navy">Go to the home page</a>
        <a href="{{ route('contact') }}" class="btn-gold">Service times and directions</a>
    </div>
</section>
</x-layout>

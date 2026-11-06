{{-- One ministry as a row: photo + name + summary. $m is an App\Models\Ministry --}}
<li class="grid gap-5 py-6 sm:grid-cols-[13rem_1fr] sm:items-center">
    @if ($m->image_url)
        <img src="{{ $m->image_url }}" alt="" class="aspect-[4/3] w-full rounded-lg object-cover" loading="lazy" width="416" height="312">
    @endif
    <div>
        <h3 class="h3">{{ $m->name }}</h3>
        <p class="prose-width mt-2">{{ $m->summary }}</p>
    </div>
</li>

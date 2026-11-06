<li class="card group transition duration-200 hover:-translate-y-1 hover:shadow-xl hover:" data-reveal>
    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="{{ asset('images/'.$m['image']) }}" alt="" class="size-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" width="1024" height="765">
    </div>
    <div class="p-6">
        <h3 class="font-display text-lg font-bold text-navy-900">{{ $m['name'] }}</h3>
        <p class="mt-2 text-slate-600">{{ $m['text'] }}</p>
    </div>
</li>

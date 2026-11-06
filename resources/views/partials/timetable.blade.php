{{-- Weekly rhythm as a real timetable: day / time / gathering --}}
<table class="w-full text-left">
    <caption class="sr-only">Weekly services</caption>
    <tbody class="divide-y divide-slate-200 border-y border-slate-200">
        @foreach ($services as $s)
            <tr>
                <th scope="row" class="py-4 pr-4 font-display text-lg font-semibold text-navy-900 sm:w-40">{{ $s->day }}</th>
                <td class="py-4 pr-4 whitespace-nowrap text-royal-700 tabular-nums sm:w-44">{{ $s->time }}</td>
                <td class="py-4 font-medium text-navy-900">{{ $s->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

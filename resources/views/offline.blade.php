@php
    $c = config('church');
    $services = \App\Models\ServiceTime::orderBy('sort')->get();
@endphp
{{-- Cached by the service worker and shown when there's no connection. Self-contained: no external CSS or fonts. --}}
<!DOCTYPE html>
<html lang="en-ZA">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0a2370">
    <title>You’re offline | {{ $c['name'] }} {{ $c['branch'] }}</title>
    <style>
        body { margin: 0; min-height: 100vh; background: #0a2370; color: #fff; font: 18px/1.6 system-ui, -apple-system, 'Segoe UI', sans-serif; }
        main { max-width: 34rem; margin: 0 auto; padding: 3rem 1.25rem; }
        img { width: 4rem; height: 4rem; border-radius: .75rem; background: #fff; }
        h1 { font-size: 1.9rem; line-height: 1.2; margin: 1.5rem 0 .5rem; }
        h2 { font-size: 1.1rem; margin: 2rem 0 .5rem; color: #ffc93c; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: .6rem 0; border-bottom: 1px solid rgb(255 255 255 / .15); }
        td + td { text-align: right; }
        a { color: #ffc93c; }
        button { margin-top: 2rem; min-height: 3rem; padding: 0 1.5rem; border: 0; border-radius: .4rem; background: #f5b50a; color: #061650; font: inherit; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
<main>
    <img src="/images/icon-192.png" alt="">
    <h1>You’re offline</h1>
    <p>Check your connection and try again. Here’s what you need to find us in the meantime.</p>

    <h2>Every week</h2>
    <table>
        @foreach ($services as $s)
            <tr><td>{{ $s->day }} {{ $s->time }}</td><td>{{ $s->name }}</td></tr>
        @endforeach
    </table>

    <h2>Where we meet</h2>
    <p>{{ $c['address'] }}</p>

    <h2>Call us</h2>
    <p>@foreach ($c['phones'] as $ph)<a href="tel:+27{{ ltrim(str_replace(' ', '', $ph), '0') }}">{{ $ph }}</a>@if (! $loop->last) / @endif @endforeach</p>

    <button type="button" onclick="location.reload()">Try again</button>
</main>
</body>
</html>

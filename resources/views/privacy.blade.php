@php
    use App\Models\Setting;
    $c = config('church');
    $officer = Setting::get('information_officer');
    $officerContact = Setting::get('information_officer_contact');
@endphp
{{-- POPIA privacy notice. Wording to be reviewed and approved by church leadership (see README). --}}
<x-layout title="Privacy notice" description="How Glad Tidings Fellowship Bethel Centre collects, uses and protects your personal information (POPIA).">
<x-page-hero title="Privacy notice">How we look after the personal information you share with us, in line with the Protection of Personal Information Act (POPIA).</x-page-hero>

<section class="py-16 sm:py-20">
    <div class="mx-auto max-w-3xl space-y-10 px-4 text-lg sm:px-6">
        <div>
            <h2 class="h2">Who we are</h2>
            <p class="mt-3">{{ $c['name'] }} {{ $c['branch'] }}, {{ $c['address'] }} (“the church”, “we”).</p>
        </div>
        <div>
            <h2 class="h2">What we collect and why</h2>
            <ul class="mt-3 list-disc space-y-2 pl-6">
                <li><strong>Prayer requests:</strong> your request and, if you choose, your name and contact details, so we can pray and follow up.</li>
                <li><strong>Connect cards:</strong> your name, contact details, area and interests, so we can welcome you and help you get connected.</li>
                <li><strong>Church records:</strong> for members and regular attenders, contact details, birthday and home group, so we can care for and communicate with the church family.</li>
            </ul>
            <p class="mt-3">We only use this information for church ministry. We never sell it or share it for marketing.</p>
        </div>
        <div>
            <h2 class="h2">Who can see it</h2>
            <p class="mt-3">Only church staff and leaders with a login, and only what their role needs. Requests marked “pastors only” can be read by the pastors alone. Home group leaders see only their own group.</p>
        </div>
        <div>
            <h2 class="h2">How long we keep it</h2>
            <p class="mt-3">We keep information only as long as it is needed for the purpose you gave it, and review our records at least once a year. You can ask us to delete your information at any time.</p>
        </div>
        <div>
            <h2 class="h2">Cookies and third parties</h2>
            <p class="mt-3">This website uses only an essential cookie needed for forms to work securely. Maps and videos from Google, YouTube and Facebook are only loaded if you click to show them. Our website is hosted in South Africa.</p>
        </div>
        <div>
            <h2 class="h2">Your rights</h2>
            <p class="mt-3">You may ask to see, correct or delete the personal information we hold about you, or object to how we use it. If you are unhappy with our response you may complain to the <a href="https://inforegulator.org.za" class="link" target="_blank" rel="noopener">Information Regulator</a>.</p>
        </div>
        <div>
            <h2 class="h2">Contact our Information Officer</h2>
            <p class="mt-3">
                @if ($officer) {{ $officer }}@if ($officerContact), {{ $officerContact }}@endif. @else Please contact the church office. @endif
                You can also call {{ $c['phones'][0] }} or visit us at {{ $c['address'] }}.
            </p>
        </div>
    </div>
</section>
</x-layout>

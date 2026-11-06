<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PrayerRequestController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: bots fill the hidden "website" field; pretend success.
        if ($request->filled('website')) {
            return redirect()->to(url('/'))->withFragment('prayer')->with('prayer_sent', true);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'max:100'],
            'contact' => ['nullable', 'string', 'max:150'],
            'request' => ['required', 'string', 'min:5', 'max:3000'],
            'pastors_only' => ['nullable', 'boolean'],
        ], [
            'request.required' => 'Please tell us what we can pray with you about.',
        ]);

        if ($validator->fails()) {
            return redirect()->to(url('/'))->withFragment('prayer')->withErrors($validator)->withInput();
        }

        $prayer = PrayerRequest::create($validator->validated() + ['pastors_only' => $request->boolean('pastors_only')]);

        // Saved first, so a mail outage never loses a request.
        if ($to = config('church.email')) {
            try {
                Mail::raw(
                    "New prayer request".($prayer->pastors_only ? ' (pastors only)' : '')."\n\n"
                    ."Name: ".($prayer->name ?: 'Anonymous')."\nContact: ".($prayer->contact ?: '-')."\n\n{$prayer->request}",
                    fn ($m) => $m->to($to)->subject('Prayer request from the website')
                );
            } catch (\Throwable $e) {
                Log::error('Prayer request mail failed', ['id' => $prayer->id, 'error' => $e->getMessage()]);
            }
        }

        return redirect()->to(url('/'))->withFragment('prayer')->with('prayer_sent', true);
    }
}

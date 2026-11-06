<?php

namespace App\Http\Controllers;

use App\Models\ConnectCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConnectCardController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: bots fill the hidden "website" field; pretend success.
        if ($request->filled('website')) {
            return redirect()->route('connect')->with('connect_sent', true);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'area' => ['nullable', 'string', 'max:100'],
            'visited_on' => ['nullable', 'date', 'before_or_equal:today'],
            'how_heard' => ['nullable', 'string', 'max:100'],
            'interests' => ['nullable', 'array'],
            'interests.*' => [Rule::in(array_keys(ConnectCard::INTERESTS))],
            'message' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ], [
            'name.required' => 'Please tell us your name.',
            'email.email' => 'Please check the email address. It should look like name@example.com.',
            'consent.accepted' => 'Please tick the box so we may keep your details and contact you.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('connect')->withErrors($validator)->withInput();
        }

        $data = collect($validator->validated())->except('consent')->all();
        $card = ConnectCard::create($data + ['consent_at' => now()]);

        // Saved first, so a mail outage never loses a card.
        if ($to = config('church.email')) {
            try {
                Mail::raw(
                    "New connect card from {$card->name}\nPhone: ".($card->phone ?: '-')."\nEmail: ".($card->email ?: '-')
                    ."\nArea: ".($card->area ?: '-')."\n\nOpen it in the admin: ".url('/admin/connect-cards'),
                    fn ($m) => $m->to($to)->subject('New connect card from the website')
                );
            } catch (\Throwable $e) {
                Log::error('Connect card mail failed', ['id' => $card->id, 'error' => $e->getMessage()]);
            }
        }

        return redirect()->route('connect')->with('connect_sent', true);
    }
}

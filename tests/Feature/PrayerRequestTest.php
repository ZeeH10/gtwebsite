<?php

namespace Tests\Feature;

use App\Models\PrayerRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrayerRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_prayer_request_is_saved_with_consent(): void
    {
        $this->post('/prayer', ['request' => 'Please pray for my family.', 'pastors_only' => '1', 'consent' => '1'])
            ->assertRedirect('/prayer')->assertSessionHas('prayer_sent');

        $prayer = PrayerRequest::sole();
        $this->assertTrue($prayer->pastors_only);
        $this->assertNotNull($prayer->consent_at);
        $this->assertSame('new', $prayer->status);
    }

    public function test_request_and_consent_are_required_and_honeypot_is_ignored(): void
    {
        $this->post('/prayer', ['request' => ''])->assertSessionHasErrors(['request', 'consent']);
        $this->post('/prayer', ['request' => 'Pray for me please'])->assertSessionHasErrors('consent');
        $this->post('/prayer', ['request' => 'spam spam', 'consent' => '1', 'website' => 'http://spam'])->assertSessionHas('prayer_sent');

        $this->assertSame(0, PrayerRequest::count());
    }
}

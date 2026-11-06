<?php

namespace Tests\Feature;

use App\Models\PrayerRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrayerRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_page_renders(): void
    {
        $this->withoutVite();
        foreach (['/', '/about', '/ministries', '/events', '/watch', '/give', '/visit', '/prayer'] as $url) {
            $this->get($url)->assertOk()->assertSee('Bethel Centre');
        }
        $this->get('/about')->assertSee('Pastor Gratitude Kudyachete');
    }

    public function test_prayer_request_is_saved(): void
    {
        $this->post('/prayer', ['request' => 'Please pray for my family.', 'pastors_only' => '1'])
            ->assertRedirect('/prayer')->assertSessionHas('prayer_sent');

        $this->assertDatabaseHas('prayer_requests', ['request' => 'Please pray for my family.', 'pastors_only' => true]);
    }

    public function test_empty_request_is_rejected_and_honeypot_is_ignored(): void
    {
        $this->post('/prayer', ['request' => ''])->assertSessionHasErrors('request');
        $this->post('/prayer', ['request' => 'spam spam', 'website' => 'http://spam'])->assertSessionHas('prayer_sent');

        $this->assertSame(0, PrayerRequest::count());
    }
}

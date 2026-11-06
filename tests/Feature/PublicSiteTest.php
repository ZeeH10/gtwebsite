<?php

namespace Tests\Feature;

use App\Models\ConnectCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(); // explicit: the in-memory DB is shared across test classes, so $seed = true isn't reliable
    }

    public function test_every_public_page_renders(): void
    {
        foreach (['/', '/about', '/ministries', '/events', '/watch', '/give', '/visit', '/connect', '/prayer', '/privacy'] as $url) {
            $this->get($url)->assertOk()->assertSee('Bethel Centre');
        }

        $this->get('/about')->assertSee('Pastor Gratitude Kudyachete');
        $this->get('/ministries')->assertSee('Ushering')->assertSee('Hosting Team'); // teams without photos still listed
        $this->get('/give')->assertSee('083 515 496')->assertSee('051001');
        $this->get('/events')->assertSee('Possessing the Remaining Land'); // past conference, from the database
    }

    public function test_sitemap_robots_and_404(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml')->assertSee(url('/privacy'));
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /admin')->assertSee(url('/sitemap.xml'));
        $this->get('/no-such-page')->assertNotFound()->assertSee('couldn’t find that page', false);
    }

    public function test_pwa_files_are_in_place(): void
    {
        $this->get('/offline')->assertOk()->assertSee('You’re offline', false)->assertSee('Morning Service');
        $this->get('/')->assertSee('rel="manifest"', false);

        $manifest = json_decode(file_get_contents(public_path('manifest.webmanifest')), true);
        $this->assertSame('standalone', $manifest['display']);
        foreach ($manifest['icons'] as $icon) {
            $this->assertFileExists(public_path(ltrim($icon['src'], '/')));
        }
        $this->assertFileExists(public_path('sw.js'));
    }

    public function test_connect_card_is_saved_with_consent(): void
    {
        $this->post('/connect', [
            'name' => 'Thandi Visitor', 'phone' => '082 000 0000', 'area' => 'Walmer',
            'interests' => ['home_group', 'baptism'], 'consent' => '1',
        ])->assertRedirect('/connect')->assertSessionHas('connect_sent');

        $card = ConnectCard::sole();
        $this->assertSame(['home_group', 'baptism'], $card->interests);
        $this->assertNotNull($card->consent_at);
    }

    public function test_connect_card_validation_and_honeypot(): void
    {
        $this->post('/connect', ['name' => ''])->assertSessionHasErrors(['name', 'consent']);
        $this->post('/connect', ['name' => 'X', 'consent' => '1', 'interests' => ['hacking']])->assertSessionHasErrors('interests.0');
        $this->post('/connect', ['name' => 'Bot', 'consent' => '1', 'website' => 'spam'])->assertSessionHas('connect_sent');

        $this->assertSame(0, ConnectCard::count());
    }
}

<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_root_redirects_to_arabic(): void
    {
        $this->get('/')->assertRedirect('/ar');
    }

    /**
     * @return array<string, array{string}>
     */
    public static function pages(): array
    {
        return [
            'home' => ['home'],
            'about' => ['about'],
            'services' => ['services'],
            'training' => ['training'],
            'contact' => ['contact'],
        ];
    }

    #[DataProvider('pages')]
    public function test_pages_render_in_both_locales(string $route): void
    {
        foreach (['ar', 'en'] as $locale) {
            $this->get(route($route, ['locale' => $locale]))->assertOk();
        }
    }

    public function test_home_shows_seeded_content(): void
    {
        $this->get('/ar')
            ->assertOk()
            ->assertSee('انطلق من حيث أنت', false)
            ->assertSee('مسك الدفاتر', false);

        $this->get('/en')
            ->assertOk()
            ->assertSee('Start From Where You Are', false)
            ->assertSee('Bookkeeping', false);
    }

    public function test_arabic_home_is_rtl(): void
    {
        $this->get('/ar')->assertSee('dir="rtl"', false);
        $this->get('/en')->assertSee('dir="ltr"', false);
    }

    public function test_contact_form_stores_a_message(): void
    {
        $response = $this->post(route('contact.store', ['locale' => 'en']), [
            'name' => 'Test Person',
            'email' => 'person@example.com',
            'message' => 'Hello, this is a valid enquiry message.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('contact_sent', true);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'person@example.com',
            'locale' => 'en',
        ]);
    }

    public function test_contact_honeypot_blocks_spam(): void
    {
        $this->post(route('contact.store', ['locale' => 'en']), [
            'name' => 'Spam Bot',
            'email' => 'bot@example.com',
            'message' => 'Buy cheap things now at spam dot com.',
            'website' => 'http://spam.example',
        ])->assertSessionHasErrors('website');

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_contact_validation_rejects_bad_input(): void
    {
        $this->post(route('contact.store', ['locale' => 'en']), [
            'name' => 'A',
            'email' => 'not-an-email',
            'message' => 'short',
        ])->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_sitemap_and_robots(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('hreflang="ar"', false)
            ->assertSee('hreflang="en"', false)
            ->assertSee('hreflang="x-default"', false);

        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap:');
    }

    public function test_hreflang_alternates_in_head(): void
    {
        $this->get('/ar')
            ->assertSee('rel="alternate" hreflang="en"', false)
            ->assertSee('application/ld+json', false);
    }

    public function test_unknown_locale_is_not_matched(): void
    {
        $this->get('/fr')->assertNotFound();
    }
}

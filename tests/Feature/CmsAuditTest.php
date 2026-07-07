<?php

namespace Tests\Feature;

use App\Models\HeroSlide;
use App\Models\HomepageSection;
use App\Models\Media;
use App\Models\Product;
use App\Models\User;
use App\Services\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function admin(): User
    {
        return User::where('username', '017552223')->firstOrFail();
    }

    protected function visitor(): User
    {
        return User::factory()->create(['is_admin' => false]);
    }

    /* ---------------------------------------------------------------------
     | Public site
     * -------------------------------------------------------------------*/

    public function test_homepage_renders_slides_and_products(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('AMS')
            ->assertSee('SmartSell')
            ->assertSee('hero-swiper', false);
    }

    public function test_homepage_respects_section_visibility_and_order(): void
    {
        HomepageSection::where('key', 'faq')->update(['is_active' => false]);

        $this->get('/')->assertOk()->assertDontSee('Frequently asked questions');
    }

    public function test_product_pages_render(): void
    {
        $this->get('/products/ams')->assertOk()->assertSee('Apartment Management');
        $this->get('/products/smart')->assertOk()->assertSee('SmartSell');
    }

    public function test_unpublished_products_are_hidden_from_public(): void
    {
        Product::where('slug', 'ams')->update(['status' => 'hidden']);

        $this->get('/products/ams')->assertNotFound();
        $this->get('/products/nonexistent')->assertNotFound();
    }

    public function test_future_publish_date_hides_product(): void
    {
        Product::where('slug', 'ams')->update(['published_at' => now()->addDay()]);

        $this->get('/products/ams')->assertNotFound();
        $this->get('/')->assertOk()->assertDontSee('/products/ams');
    }

    public function test_sitemap_lists_published_products_only(): void
    {
        Product::where('slug', 'smart')->update(['status' => 'draft']);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('/products/ams')
            ->assertDontSee('/products/smart');
    }

    /* ---------------------------------------------------------------------
     | Authentication & authorization
     * -------------------------------------------------------------------*/

    public function test_login_screen_renders(): void
    {
        $this->get('/login')->assertOk()->assertSee('Email or Username');
    }

    public function test_registration_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [])->assertNotFound();
    }

    public function test_admin_can_login_with_username(): void
    {
        $this->post('/login', ['email' => '017552223', 'password' => '12345678'])
            ->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_can_login_with_email(): void
    {
        $this->post('/login', ['email' => 'admin@minidigital.dev', 'password' => '12345678'])
            ->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_wrong_password_is_rejected(): void
    {
        $this->post('/login', ['email' => '017552223', 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guests_are_redirected_from_admin(): void
    {
        foreach (['/admin', '/admin/products', '/admin/slides', '/admin/media', '/admin/homepage', '/admin/settings'] as $path) {
            $this->get($path)->assertRedirect('/login');
        }
    }

    public function test_non_admin_users_are_forbidden_from_admin(): void
    {
        $user = $this->visitor();

        foreach (['/admin', '/admin/products', '/admin/settings'] as $path) {
            $this->actingAs($user)->get($path)->assertForbidden();
        }

        $this->actingAs($user)
            ->post(route('admin.slides.reorder'), ['order' => [1]])
            ->assertForbidden();
    }

    public function test_dashboard_route_redirects_into_admin(): void
    {
        $this->actingAs($this->admin())->get('/dashboard')->assertRedirect(route('admin.dashboard'));
    }

    public function test_logout_works(): void
    {
        $this->actingAs($this->admin())->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    /* ---------------------------------------------------------------------
     | Admin pages render
     * -------------------------------------------------------------------*/

    public function test_all_admin_pages_render(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Total Products');
        $this->actingAs($admin)->get('/admin/products')->assertOk()->assertSee('AMS');
        $this->actingAs($admin)->get('/admin/products/create')->assertOk();
        $this->actingAs($admin)->get('/admin/products/ams/edit')->assertOk();
        $this->actingAs($admin)->get('/admin/slides')->assertOk()->assertSee('Slideshow Settings');
        $this->actingAs($admin)->get('/admin/slides/create')->assertOk();
        $this->actingAs($admin)->get('/admin/slides/'.HeroSlide::first()->id.'/edit')->assertOk();
        $this->actingAs($admin)->get('/admin/media')->assertOk();
        $this->actingAs($admin)->get('/admin/homepage')->assertOk()->assertSee('Hero Slideshow');
        $this->actingAs($admin)->get('/admin/settings')->assertOk()->assertSee('Company Name');
    }

    /* ---------------------------------------------------------------------
     | Product CRUD
     * -------------------------------------------------------------------*/

    public function test_product_can_be_created_with_images_and_tags(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin())->post(route('admin.products.store'), [
            'name' => 'Test Product',
            'slug' => '',
            'short_description' => 'A test product.',
            'status' => 'published',
            'featured' => '1',
            'tags' => 'Alpha, Beta, Alpha',
            'features' => "One\nTwo\n\nThree",
            'tech_stack' => "Laravel\nMySQL",
            'display_order' => 5,
            'animation' => 'fade',
            'logo_file' => UploadedFile::fake()->image('logo.png', 200, 200),
            'cover_image_file' => UploadedFile::fake()->image('cover.jpg', 800, 500),
            'gallery_files' => [
                UploadedFile::fake()->image('shot1.png', 640, 400),
                UploadedFile::fake()->image('shot2.png', 640, 400),
            ],
        ]);

        $product = Product::where('slug', 'test-product')->first();

        $this->assertNotNull($product, 'Product was not created (slug auto-generation failed?)');
        $response->assertRedirect(route('admin.products.edit', $product));

        $this->assertTrue($product->featured);
        $this->assertSame(['One', 'Two', 'Three'], $product->features);
        $this->assertSame(['Laravel', 'MySQL'], $product->tech_stack);
        $this->assertNotNull($product->published_at, 'published_at should default when publishing');
        $this->assertEqualsCanonicalizing(['alpha', 'beta'], $product->tags->pluck('slug')->all());
        $this->assertCount(2, $product->images);

        Storage::disk('public')->assertExists($product->logo);
        Storage::disk('public')->assertExists($product->cover_image);
        foreach ($product->images as $image) {
            Storage::disk('public')->assertExists($image->path);
        }

        // Media library registered the uploads too.
        $this->assertSame(4, Media::where('folder', 'products')->count());
    }

    public function test_product_validation_rejects_bad_input(): void
    {
        $this->actingAs($this->admin())->post(route('admin.products.store'), [
            'name' => '',
            'status' => 'bogus',
            'website_url' => 'not-a-url',
        ])->assertSessionHasErrors(['name', 'status', 'website_url']);
    }

    public function test_duplicate_slug_is_rejected(): void
    {
        $this->actingAs($this->admin())->post(route('admin.products.store'), [
            'name' => 'AMS', 'slug' => 'ams', 'status' => 'draft',
        ])->assertSessionHasErrors('slug');
    }

    public function test_product_can_be_updated(): void
    {
        $this->actingAs($this->admin())->put(route('admin.products.update', 'ams'), [
            'name' => 'AMS Pro',
            'slug' => 'ams',
            'status' => 'published',
            'version' => '3.0',
            'tags' => 'Property',
        ])->assertRedirect();

        $product = Product::where('slug', 'ams')->first();
        $this->assertSame('AMS Pro', $product->name);
        $this->assertSame('3.0', $product->version);
        $this->assertSame(['property'], $product->tags->pluck('slug')->all());
    }

    public function test_product_can_be_deleted_and_cascades(): void
    {
        $product = Product::where('slug', 'smart')->first();
        $product->images()->create(['path' => 'x.png', 'display_order' => 1]);
        $imageId = $product->images()->first()->id;

        $this->actingAs($this->admin())
            ->delete(route('admin.products.destroy', 'smart'))
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', ['slug' => 'smart']);
        $this->assertDatabaseMissing('product_images', ['id' => $imageId]);
        // Attached slide should survive with product_id nulled.
        $this->assertDatabaseHas('hero_slides', ['title' => 'SmartSell', 'product_id' => null]);
    }

    public function test_gallery_image_delete_is_scoped_to_its_product(): void
    {
        $ams = Product::where('slug', 'ams')->first();
        $smart = Product::where('slug', 'smart')->first();
        $foreignImage = $smart->images()->create(['path' => 'x.png', 'display_order' => 1]);

        // Image belongs to smart — deleting via ams URL must 404.
        $this->actingAs($this->admin())
            ->delete(route('admin.products.images.destroy', [$ams, $foreignImage]))
            ->assertNotFound();

        $this->actingAs($this->admin())
            ->delete(route('admin.products.images.destroy', [$smart, $foreignImage]))
            ->assertRedirect();
        $this->assertDatabaseMissing('product_images', ['id' => $foreignImage->id]);
    }

    /* ---------------------------------------------------------------------
     | Slides
     * -------------------------------------------------------------------*/

    public function test_slide_can_be_created(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.slides.store'), [
            'title' => 'New Slide',
            'subtitle' => 'Testing',
            'animation' => 'zoom',
            'badges' => 'Fast, Simple',
            'is_active' => '1',
            'display_order' => 9,
            'image_file' => UploadedFile::fake()->image('bg.jpg', 1600, 900),
        ])->assertRedirect(route('admin.slides.index'));

        $slide = HeroSlide::where('title', 'New Slide')->first();
        $this->assertNotNull($slide);
        $this->assertSame(['Fast', 'Simple'], $slide->badges);
        Storage::disk('public')->assertExists($slide->image);
    }

    public function test_slide_validation_rejects_bad_animation(): void
    {
        $this->actingAs($this->admin())->post(route('admin.slides.store'), [
            'title' => 'X', 'animation' => 'spin',
        ])->assertSessionHasErrors('animation');
    }

    public function test_slide_toggle_and_delete(): void
    {
        $slide = HeroSlide::first();
        $wasActive = $slide->is_active;

        $this->actingAs($this->admin())->post(route('admin.slides.toggle', $slide))->assertRedirect();
        $this->assertSame(! $wasActive, $slide->fresh()->is_active);

        $this->actingAs($this->admin())->delete(route('admin.slides.destroy', $slide))->assertRedirect();
        $this->assertDatabaseMissing('hero_slides', ['id' => $slide->id]);
    }

    public function test_inactive_slides_are_hidden_from_homepage(): void
    {
        HeroSlide::query()->update(['is_active' => false]);

        $this->get('/')->assertOk()->assertDontSee('hero-swiper');
    }

    public function test_slides_reorder_persists(): void
    {
        $ids = HeroSlide::ordered()->pluck('id')->all();
        $reversed = array_reverse($ids);

        $this->actingAs($this->admin())
            ->postJson(route('admin.slides.reorder'), ['order' => $reversed])
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertSame($reversed, HeroSlide::ordered()->pluck('id')->all());
    }

    public function test_slides_reorder_validates_payload(): void
    {
        $this->actingAs($this->admin())
            ->postJson(route('admin.slides.reorder'), ['order' => 'nope'])
            ->assertUnprocessable();
    }

    public function test_slideshow_settings_update_and_bounds(): void
    {
        $this->actingAs($this->admin())->post(route('admin.slides.settings'), [
            'slideshow_autoplay_delay' => 8000,
            'slideshow_transition_duration' => 1200,
        ])->assertRedirect();

        $this->assertSame('8000', setting('slideshow_autoplay_delay'));
        $this->assertSame('1200', setting('slideshow_transition_duration'));

        $this->actingAs($this->admin())->post(route('admin.slides.settings'), [
            'slideshow_autoplay_delay' => 100,
            'slideshow_transition_duration' => 99999,
        ])->assertSessionHasErrors(['slideshow_autoplay_delay', 'slideshow_transition_duration']);
    }

    /* ---------------------------------------------------------------------
     | Media library
     * -------------------------------------------------------------------*/

    public function test_media_multi_upload_update_and_delete(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.media.store'), [
            'files' => [
                UploadedFile::fake()->image('a.png', 100, 80),
                UploadedFile::fake()->image('b.jpg', 300, 200),
            ],
            'folder' => 'Test Folder!',
        ])->assertRedirect();

        $this->assertSame(2, Media::count());
        $media = Media::first();
        $this->assertSame('test-folder', $media->folder, 'folder name should be slugified');
        $this->assertSame(100, $media->width);
        Storage::disk('public')->assertExists($media->path);

        // Update alt + replace file.
        $this->actingAs($admin)->put(route('admin.media.update', $media), [
            'alt' => 'Alt text',
            'file' => UploadedFile::fake()->image('replacement.png', 50, 50),
        ])->assertRedirect();

        $media->refresh();
        $this->assertSame('Alt text', $media->alt);
        $this->assertSame(50, $media->width);
        Storage::disk('public')->assertExists($media->path);

        // Delete removes DB row and file.
        $path = $media->path;
        $this->actingAs($admin)->delete(route('admin.media.destroy', $media))->assertRedirect();
        $this->assertDatabaseMissing('media_library', ['id' => $media->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_media_upload_rejects_non_images(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.media.store'), [
            'files' => [UploadedFile::fake()->create('evil.php', 10, 'text/x-php')],
        ])->assertSessionHasErrors();

        $this->assertSame(0, Media::count());
    }

    /* ---------------------------------------------------------------------
     | Settings
     * -------------------------------------------------------------------*/

    public function test_settings_update_persists_and_flushes_cache(): void
    {
        $this->assertSame('MinimalDigital', setting('company_name'));

        $this->actingAs($this->admin())->post(route('admin.settings.update'), [
            'settings' => [
                'company_name' => 'NewCo',
                'email' => 'hi@newco.dev',
                'not_a_real_key' => 'should be ignored',
            ],
        ])->assertRedirect();

        Settings::flush();
        $this->assertSame('NewCo', setting('company_name'));
        $this->assertSame('hi@newco.dev', setting('email'));
        $this->assertNull(setting('not_a_real_key'), 'unknown keys must not be stored');

        // The public site reflects the change.
        $this->get('/')->assertSee('NewCo');
    }

    public function test_settings_logo_upload(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.settings.update'), [
            'settings' => ['company_name' => 'MinimalDigital'],
            'logo_file' => UploadedFile::fake()->image('logo.png', 180, 40),
        ])->assertRedirect();

        Settings::flush();
        Storage::disk('public')->assertExists(setting('logo'));
    }

    /* ---------------------------------------------------------------------
     | Homepage builder
     * -------------------------------------------------------------------*/

    public function test_homepage_sections_reorder_and_toggle(): void
    {
        $admin = $this->admin();
        $ids = HomepageSection::ordered()->pluck('id')->all();
        $reversed = array_reverse($ids);

        $this->actingAs($admin)
            ->postJson(route('admin.homepage.reorder'), ['order' => $reversed])
            ->assertOk();
        $this->assertSame($reversed, HomepageSection::ordered()->pluck('id')->all());

        $section = HomepageSection::where('key', 'contact')->first();
        $this->actingAs($admin)->post(route('admin.homepage.toggle', $section))->assertRedirect();
        $this->assertFalse($section->fresh()->is_active);
    }

    /* ---------------------------------------------------------------------
     | Helpers
     * -------------------------------------------------------------------*/

    public function test_media_url_helper(): void
    {
        $this->assertNull(media_url(null));
        $this->assertNull(media_url(''));
        $this->assertSame('/images/x.svg', media_url('/images/x.svg'));
        $this->assertSame('https://cdn.example.com/a.png', media_url('https://cdn.example.com/a.png'));
        $this->assertStringContainsString('/storage/media/x.png', media_url('media/x.png'));
    }
}

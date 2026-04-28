<?php

namespace Tests\Feature;

use App\Models\SalesPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesPageFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirected_from_sales_pages(): void
    {
        $this->get('/sales-pages')->assertRedirect('/login');
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_create_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/sales-pages/create')
            ->assertOk()
            ->assertSee('Tell the AI about your product')
            ->assertSee('Product / service name', false);
    }

    public function test_user_can_generate_and_preview_sales_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sales-pages', [
            'product_name' => 'FocusFlow Pro',
            'description' => 'A minimalist task tracker that uses AI to estimate task time and protect calendar focus blocks.',
            'features' => "AI time estimation\nCalendar auto-blocking\nDistraction-free mode",
            'target_audience' => 'remote knowledge workers',
            'price' => '$12 / month',
            'unique_selling_points' => 'The only tool that protects your calendar automatically.',
            'tone' => 'persuasive',
            'template' => 'modern',
        ]);

        $response->assertRedirect();
        $page = SalesPage::where('user_id', $user->id)->latest('id')->firstOrFail();

        $this->assertSame('ready', $page->status);
        $this->assertNotEmpty($page->generated_content);
        $this->assertArrayHasKey('headline', $page->generated_content);
        $this->assertArrayHasKey('benefits', $page->generated_content);
        $this->assertArrayHasKey('cta', $page->generated_content);
        $this->assertSame(['AI time estimation', 'Calendar auto-blocking', 'Distraction-free mode'], $page->features);

        $response = $this->actingAs($user)
            ->get("/sales-pages/{$page->id}")
            ->assertOk()
            ->assertSee('FocusFlow Pro')
            ->assertSee($page->generated_content['cta']['primary']);

        // Headline is rendered split across multiple spans for design impact;
        // assert that at least the first word survives in the rendered HTML.
        $firstWord = explode(' ', $page->generated_content['headline'])[0];
        $response->assertSee($firstWord);
    }

    public function test_user_can_list_search_and_delete(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        SalesPage::create([
            'user_id' => $user->id,
            'product_name' => 'Apex Mixer',
            'description' => 'A pro DJ mixer for studios.',
            'features' => ['EQ', 'Mic input'],
            'target_audience' => 'DJs',
            'tone' => 'persuasive',
            'template' => 'modern',
            'status' => 'ready',
            'generated_content' => ['headline' => 'Spin like a pro'],
        ]);

        SalesPage::create([
            'user_id' => $other->id,
            'product_name' => 'Other Product',
            'description' => 'Should not appear for first user.',
            'features' => ['x'],
            'target_audience' => 'others',
            'tone' => 'casual',
            'template' => 'classic',
            'status' => 'ready',
            'generated_content' => ['headline' => 'No'],
        ]);

        $this->actingAs($user)->get('/sales-pages')
            ->assertOk()
            ->assertSee('Apex Mixer')
            ->assertDontSee('Other Product');

        $this->actingAs($user)->get('/sales-pages?q=Apex')
            ->assertOk()
            ->assertSee('Apex Mixer');

        $this->actingAs($user)->get('/sales-pages?q=Mixerwhatever')
            ->assertOk()
            ->assertSee('No matches found');

        $page = SalesPage::where('user_id', $user->id)->first();
        $this->actingAs($user)->delete("/sales-pages/{$page->id}")
            ->assertRedirect('/sales-pages');
        $this->assertDatabaseMissing('sales_pages', ['id' => $page->id]);
    }

    public function test_user_cannot_access_another_users_page(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();
        $page = SalesPage::create([
            'user_id' => $owner->id,
            'product_name' => 'Secret',
            'description' => 'Private',
            'features' => ['a'],
            'target_audience' => 'me',
            'tone' => 'persuasive',
            'template' => 'modern',
            'status' => 'ready',
            'generated_content' => ['headline' => 'h'],
        ]);

        $this->actingAs($stranger)->get("/sales-pages/{$page->id}")->assertForbidden();
    }
}

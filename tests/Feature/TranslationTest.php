<?php
// tests/Feature/TranslationTest.php
namespace Tests\Feature;

use App\Models\Translation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function test_can_create_translation()
    {
        $response = $this->postJson('/api/translations', [
            'key' => 'welcome',
            'locale' => 'en',
            'value' => 'Welcome',
            'tags' => ['web']
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'key', 'locale', 'value', 'tags']);
    }

    public function test_export_performance()
    {
        Translation::factory()->count(100000)->create(['locale' => 'en']);
        
        $start = microtime(true);
        $response = $this->get('/api/translations/export?locale=en');
        $duration = (microtime(true) - $start) * 1000;

        $response->assertStatus(200);
        $this->assertLessThan(500, $duration, 'Export should respond in under 500ms');
    }
}
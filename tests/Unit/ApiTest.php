<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Api;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testIndex()
    {
        $api = Api::factory()->create();  // Crear una instancia de API para asegurarse de que hay algo para recuperar
        $response = $this->getJson('/api/apis');
        $response->assertStatus(200)->assertJson(['message' => 'APIs retrieved successfully']);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Test API',
            'base_url' => 'https://testapi.com',
        ];
        $response = $this->postJson('/api/apis', $data);
        $response->assertStatus(201)
                 ->assertJson(['message' => 'API created successfully'])
                 ->assertJsonPath('data.name', $data['name'])
                 ->assertJsonPath('data.base_url', $data['base_url']);
    }

    public function testShow()
    {
        $api = Api::factory()->create();
        $response = $this->getJson("/api/apis/{$api->id}");
        $response->assertStatus(200)
                 ->assertJson(['message' => 'API retrieved successfully'])
                 ->assertJsonPath('data.name', $api->name)
                 ->assertJsonPath('data.base_url', $api->base_url);
    }

    public function testUpdate()
    {
        $api = Api::factory()->create();
        $updateData = [
            'name' => 'Updated API',
            'base_url' => 'https://updatedapi.com',
        ];
        $response = $this->putJson("/api/apis/{$api->id}", $updateData);
        $response->assertStatus(200)
                 ->assertJson(['message' => 'API updated successfully'])
                 ->assertJsonPath('data.name', $updateData['name'])
                 ->assertJsonPath('data.base_url', $updateData['base_url']);
    }

    public function testDestroy()
    {
        $api = Api::factory()->create();
        $response = $this->deleteJson("/api/apis/{$api->id}");
        $response->assertStatus(200)->assertJson(['message' => 'API deleted successfully']);
    }
}

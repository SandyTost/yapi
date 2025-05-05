<?php

namespace Tests\Feature;

use App\Models\TeaType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TeaTypeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    /**
     * Setup before each test
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user for tests
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);
        $this->actingAs($this->admin);
    }

    #[Test]
    public function can_create_tea_type()
    {
        // Prepare test data
        $teaTypeData = [
            'name' => $this->faker->unique()->word,
        ];

        // Execute create request
        $response = $this->post(route('type.store'), $teaTypeData);

        // Check results
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Тип чая успешно добавлен!');
        $this->assertDatabaseHas('tea_types', $teaTypeData);
    }

    #[Test]
    public function cannot_create_tea_type_with_invalid_data()
    {
        // Send request with empty name
        $response = $this->post(route('type.store'), [
            'name' => '', // Empty name should cause validation error
        ]);

        // Check validation errors
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('tea_types', ['name' => '']);
    }

    #[Test]
    public function can_update_tea_type()
    {
        // Create test tea type with name
        $teaType = TeaType::factory()->create([
            'name' => 'Test Tea Type'
        ]);
        $updatedName = $this->faker->unique()->word;

        // Execute update request
        $response = $this->patch(route('type.update', $teaType), [
            'name' => $updatedName,
        ]);

        // Check results
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Тип чая успешно изменен');
        $this->assertDatabaseHas('tea_types', [
            'id' => $teaType->id,
            'name' => $updatedName,
        ]);
    }

    #[Test]
    public function cannot_update_tea_type_with_invalid_data()
    {
        // Create test tea type with name
        $teaType = TeaType::factory()->create([
            'name' => 'Test Tea Type'
        ]);
        $originalName = $teaType->name;

        // Send request with empty name
        $response = $this->patch(route('type.update', $teaType), [
            'name' => '', // Empty name should cause validation error
        ]);

        // Check validation errors and original name preservation
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseHas('tea_types', [
            'id' => $teaType->id,
            'name' => $originalName, // Name should not change
        ]);
    }

    #[Test]
    public function cannot_update_nonexistent_tea_type()
    {
        // Use nonexistent ID
        $nonExistentId = 9999;

        // Execute update request
        $response = $this->patch(route('type.update', $nonExistentId), [
            'name' => $this->faker->word,
        ]);

        // Check 404 status (not found)
        $response->assertStatus(404);
    }

    #[Test]
    public function can_delete_tea_type_and_related_products()
    {
        // Create test tea type with name
        $teaType = TeaType::factory()->create([
            'name' => 'Test Tea Type'
        ]);

        // Create related products
        $products = Product::factory()->count(3)->create([
            'tea_type_id' => $teaType->id
        ]);

        // Execute delete request
        $response = $this->delete(route('type.destroy', $teaType));

        // Check results
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Тип чая и связанные товары удалены');

        // Check soft deletion of tea type
        $this->assertSoftDeleted('tea_types', ['id' => $teaType->id]);

        // Check soft deletion of all related products
        foreach ($products as $product) {
            $this->assertSoftDeleted('products', ['id' => $product->id]);
        }
    }

    #[Test]
    public function cannot_delete_nonexistent_tea_type()
    {
        // Use nonexistent ID
        $nonExistentId = 9999;

        // Execute delete request
        $response = $this->delete(route('type.destroy', $nonExistentId));

        // Check 404 status (not found)
        $response->assertStatus(404);
    }

    #[Test]
    public function can_restore_deleted_tea_type_and_related_products()
    {
        // Create and delete tea type with name
        $teaType = TeaType::factory()->create([
            'name' => 'Test Tea Type'
        ]);

        // Create and delete related products
        $products = Product::factory()->count(3)->create([
            'tea_type_id' => $teaType->id
        ]);

        // Soft delete tea type and products
        $teaType->delete();
        foreach ($products as $product) {
            $product->delete();
        }

        // Check soft deletion
        $this->assertSoftDeleted('tea_types', ['id' => $teaType->id]);
        foreach ($products as $product) {
            $this->assertSoftDeleted('products', ['id' => $product->id]);
        }

        // Execute restore request
        $response = $this->post(route('type.restore', $teaType->id));

        // Check results
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Тип чая и связанные товары восстановлены');

        // Check tea type restoration
        $this->assertDatabaseHas('tea_types', [
            'id' => $teaType->id,
            'deleted_at' => null
        ]);

        // Check restoration of all related products
        foreach ($products as $product) {
            $this->assertDatabaseHas('products', [
                'id' => $product->id,
                'deleted_at' => null
            ]);
        }
    }

    #[Test]
    public function cannot_restore_nonexistent_tea_type()
    {
        // Use nonexistent ID
        $nonExistentId = 9999;

        // Execute restore request
        $response = $this->post(route('type.restore', $nonExistentId));

        // Check 404 status (not found)
        $response->assertStatus(404);
    }

    #[Test]
    public function regular_user_cannot_create_tea_type()
    {
        // Create regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Login as regular user
        $this->actingAs($user);

        // Prepare test data
        $teaTypeData = [
            'name' => $this->faker->unique()->word,
        ];

        // Execute create request
        $response = $this->post(route('type.store'), $teaTypeData);

        // Check that access is forbidden
        $response->assertStatus(404);
        $this->assertDatabaseMissing('tea_types', $teaTypeData);
    }
}

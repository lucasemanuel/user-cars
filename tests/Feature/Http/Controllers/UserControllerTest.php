<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_create_user(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];

        $this->postJson(
            '/api/users',
            [
                ...$data,
                'password' => $this->faker->password()
            ]
        )->assertCreated()->assertJsonFragment($data);
        $this->assertDatabaseHas(User::class, $data);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password(),
        ];

        $this->putJson("api/users/{$user->id}", $data)->assertOk();
        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'email' => $data['email'],
        ]);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        $this->delete("api/users/{$user->id}")->assertNoContent();
        $this->assertSoftDeleted($user);
    }

    public function test_can_delete_user_with_cars(): void
    {
        $user = User::factory()
            ->has(Car::factory()->count(3))
            ->create();

        $this->delete("api/users/{$user->id}")->assertNoContent();
        $this->assertDatabaseCount('car_user', 0);
    }
}

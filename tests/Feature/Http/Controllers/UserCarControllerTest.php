<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_cars_by_users(): void
    {
        $user = User::factory()
            ->has(Car::factory()->count(5))
            ->create();
        User::factory()
            ->has(Car::factory()->count(10))
            ->create();

        $this->getJson("/api/users/$user->id/cars?per_page=10")
            ->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonFragment([
                'current_page' => 1,
                'per_page' => 10,
                'total' => 5
            ]);
    }

    public function test_can_attach_car_to_user(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $this->post("api/users/{$user->id}/cars/$car->id/attach")->assertOk();
        $this->assertDatabaseCount('car_user', 1);
    }

    public function test_can_detach_car_to_user(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()
            ->hasAttached($car)
            ->create();

        $this->post("api/users/{$user->id}/cars/$car->id/detach")->assertOk();
        $this->assertDatabaseCount('car_user', 0);
    }
}

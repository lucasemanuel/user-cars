<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_list_all_cars(): void
    {
        $cars = Car::factory(10)->create();

        $this->get('/api/cars')
            ->assertOk()
            ->assertJsonCount(10);
        $this->assertDatabaseCount(Car::class, 10);
    }

    public function test_can_create_car(): void
    {
        $data = [
            'brand' => $this->faker->company(),
            'model' => $this->faker->numerify()
        ];

        $this->postJson('/api/cars', $data)
            ->assertCreated()
            ->assertJsonFragment($data);
        $this->assertDatabaseHas(Car::class, $data);
    }

    public function test_can_update_car(): void
    {
        $car = Car::factory()->create();
        $data = [
            'brand' => $this->faker->company(),
            'model' => $this->faker->numerify()
        ];

        $this->putJson("api/cars/{$car->id}", $data)->assertOk();
        $this->assertDatabaseHas(Car::class, [
            'id' => $car->id,
            ...$data
        ]);
    }

    public function test_can_delete_car(): void
    {
        $car = Car::factory()->create();

        $this->delete("api/cars/{$car->id}")->assertNoContent();
        $this->assertSoftDeleted($car);
    }

    public function test_can_delete_car_with_cars(): void
    {
        $car = Car::factory()
            ->has(User::factory()->count(3))
            ->create();

        $this->delete("api/cars/{$car->id}")->assertNoContent();
        $this->assertDatabaseCount('car_user', 0);
    }
}

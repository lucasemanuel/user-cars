<?php

namespace App\Services;

use App\Repositories\CarRepository;

class CarService
{
    public function __construct(protected CarRepository $carRepository)
    {
    }

    public function getAll(): array
    {
        return $this->carRepository->all()->toArray();
    }

    public function createCar($data): array
    {
        return $this->carRepository->create($data)->toArray();
    }

    public function updateCar($id, $data): void
    {
        $this->carRepository->update($id, $data);
    }

    public function deleteCar($id): void
    {
        $this->carRepository->delete($id);
    }
}

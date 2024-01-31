<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function createUser($data): array
    {
        return $this->userRepository->create($data)->toArray();
    }

    public function updateUser($id, $data): void
    {
        $this->userRepository->update($id, $data);
    }

    public function deleteUser($id): void
    {
        $this->userRepository->delete($id);
    }

    public function getPaginateCars($id, $perPage = null): LengthAwarePaginator
    {
        return $this->userRepository->paginateUserCars($id, $perPage);
    }

    public function attachCarToUser($userId, $carId): void
    {
        $this->userRepository->attachCar($userId, $carId);
    }

    public function detachCarToUser($userId, $carId): void
    {
        $this->userRepository->detachCar($userId, $carId);
    }
}

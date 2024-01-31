<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new User);
    }

    public function delete($id): void
    {
        DB::transaction(function () use ($id) {
            User::findOrFail($id)->cars()->detach();
            parent::delete($id);
        });
    }

    public function paginateUserCars($id, $perPage = 20): LengthAwarePaginator
    {
        return User::findOrFail($id)->cars()->paginate($perPage);
    }

    public function attachCar($userId, $carId): void
    {
        User::findOrFail($userId)->cars()->attach($carId);
    }

    public function detachCar($userId, $carId): void
    {
        User::findOrFail($userId)->cars()->detach($carId);
    }
}

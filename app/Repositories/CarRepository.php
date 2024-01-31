<?php

namespace App\Repositories;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CarRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Car);
    }

    public function delete($id): void
    {
        DB::transaction(function () use ($id) {
            Car::findOrFail($id)->users()->detach();
            parent::delete($id);
        });
    }
}

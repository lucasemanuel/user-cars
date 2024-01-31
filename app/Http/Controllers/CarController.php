<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct(protected CarService $carService)
    {
    }

    public function index()
    {
        return $this->carService->getAll();
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'brand' => 'required|string'
        ]);

        $car = $this->carService->createCar($request->only(['model', 'brand']));

        return response($car, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'model' => 'required|string',
            'brand' => 'required|string'
        ]);

        $car = $this->carService->updateCar($id, $request->only(['model', 'brand']));

        return response($car, 200);
    }

    public function destroy($id)
    {
        $this->carService->deleteCar($id);

        return response(status: 204);
    }
}

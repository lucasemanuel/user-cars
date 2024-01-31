<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserCarController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(Request $request, $id)
    {
        $perPage = $request->input('per_page', null);
        return $this->userService->getPaginateCars($id, $perPage);
    }

    public function attach($id, $carId)
    {
        return $this->userService->attachCarToUser($id, $carId);
    }

    public function detach($id, $carId)
    {
        return $this->userService->detachCarToUser($id, $carId);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'password' => 'required|string|min:6'
        ]);

        $user = $this->userService->createUser($request->only(['email', 'name', 'password']));

        return response($user, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:6'
        ]);

        $user = $this->userService->updateUser($id, $request->only(['email', 'password']));

        return response($user, 200);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return response(status: 204);
    }
}

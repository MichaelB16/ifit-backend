<?php

namespace App\Http\Controllers;

use App\Services\NewPasswordService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NewPasswordController extends Controller
{
    public function __construct(protected NewPasswordService $newPasswordService, protected UserService $userService) {}

    public function checkToken($token): JsonResponse
    {
        $result = $this->newPasswordService->checkToken($token);

        return response()->json($result);
    }

    public function updatePassword(Request $request, $id)
    {
        $data = $request->validate(['password' => 'required']);

        $result = $this->userService->update($id, ['password' => Hash::make($data['password'])]);

        $this->newPasswordService->deleteToken($id);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $result
        ]);
    }
}

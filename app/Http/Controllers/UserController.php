<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        /** @var User */
        if (!Auth::attempt($validate)) {
            throw new HttpResponseException(response([
                "message" => "username or password wrong"
            ], 401));
        }

        /** @var User */
        $user = Auth::user();
        $token = $user->createToken('main');
        return response()->json([
            "user" => new UserResource($user),
            "token" => $token->plainTextToken
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "name" => ["required", "max:100"],
            "email" => ["required", "unique:users,email"],
            "password" => ["required", "min:6", "confirmed"],
        ]);

        $validate["id"] = Str::uuid();
        $validate["password"] = Hash::make($validate["password"]);
        $user = User::query()->create($validate);
        $token = $user->createToken("main");

        return response()->json([
            "user" => new UserResource($user),
            "token" => $token->plainTextToken
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json([
            "message" => "success logout"
        ], 200);
    }

    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}

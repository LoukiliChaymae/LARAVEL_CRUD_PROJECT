<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidationRequest;
use App\Http\Requests\RegisterValidationRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_UNAUTHORIZED = 401;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(LoginValidationRequest $request):JsonResponse
    {

        try {
            $credentials = $request->only('email', 'password');

            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], self::HTTP_UNAUTHORIZED );
            }

            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed',
            ], self::HTTP_INTERNAL_SERVER_ERROR); // You can choose an appropriate HTTP status code
        }
    }

    public function register(RegisterValidationRequest $request): JsonResponse{

        try {
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
            ]);
        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'User registration failed',
            ], self::HTTP_INTERNAL_SERVER_ERROR); // You can choose an appropriate HTTP status code
        } catch (JWTException $e) {
            // Handle JWT token-related exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed',
            ], self::HTTP_INTERNAL_SERVER_ERROR); // You can choose an appropriate HTTP status code
        }
    }

    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}

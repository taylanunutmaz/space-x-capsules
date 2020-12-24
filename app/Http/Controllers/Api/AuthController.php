<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @OA\Post (
     *     path="/api/register",
     *     @OA\Parameter(
     *          name="name",
     *          description="Name",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="email",
     *          description="Email Address",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          description="Password Confirmation",
     *          required=true,
     *          in="query",
     *      ),
     *      @OA\Response(response="200", description="Register a user.", @OA\JsonContent()),
     * )
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    /**
     * @OA\Post (
     *     path="/api/login",
     *     @OA\Parameter(
     *          name="email",
     *          description="Email address",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Response(response="200", description="Register a user.", @OA\JsonContent()),
     * )
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }

    /**
     * @OA\Get (
     *     path="/api/user",
     *     @OA\Response(response="200", description="Register a user.", @OA\JsonContent()),
     *     security={
     *          {
     *              "bearerAuth": {},
     *              "passport": {},
     *          }
     *     }
     * )
     * @param Request $request
     * @return mixed
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }
}

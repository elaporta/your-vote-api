<?php

namespace App\Http\Controllers;

// Dependencies
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\Admin;

// Requests
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthUpdatePasswordRequest;

// Exceptions
use App\Exceptions\UnauthorizedException;
use App\Exceptions\BadRequestException;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request) {
        // Exclude data from request
        $parameters = $request->safe()->only(['email', 'password']);

        // Set ttl
        $ttl = $request->get('remember_me') === true ? config('jwt.refresh_ttl') : config('jwt.ttl');

        // Set token
        $token = auth()->setTTL($ttl)->attempt($parameters);

        if(!$token) throw new UnauthorizedException();

        return $this->respondToken($token);
    }

    /**
     * Get the authenticated Admin.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile() {
        return response()->json(['message' => 'Success', 'data' => auth()->user()], 200);
    }

    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondToken($token, $statusCode = 200) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], $statusCode);
    }

    /**
     * Change admin password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(AuthUpdatePasswordRequest $request) {
        $parameters = $request->safe()->all();
 
        $admin = Admin::find(auth()->user()->id);

        // Validations
        if(!isset($admin)) throw new BadRequestException('Admin does not exist.');
        if(!Hash::check($parameters['password'], $admin->password)) throw new BadRequestException('Old password does not match.');

        // Hash password
        $admin->fill(['password' => Hash::make($parameters['new_password'])])->save();

        return response()->json(['message' => 'Success'], 200);
    }
}
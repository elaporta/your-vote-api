<?php

namespace App\Http\Controllers;

// Dependencies
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Auth\Events\Registered;

// Models
use App\Models\User;

// Requests
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthSignupRequest;

// Exceptions
use App\Exceptions\UnauthorizedException;

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
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile() {
        return response()->json(['message' => 'Success', 'data' => auth()->user()], 200);
    }

    /**
     * Log the user out (Invalidate the token).
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

    public function signup(AuthSignupRequest $request) {
        // Exclude data from request
        $parameters = $request->safe()->only(['name', 'email', 'password']);

        // Hash password
        $parameters['password'] = Hash::make($parameters['password']);

        // Create in DB
        $newUser = User::create($parameters);

        // Fire registered event for email confirmation
		if(config('app.verify_email')) {
			event(new Registered($newUser));
		}
		else{
			$newUser->markEmailAsVerified();
		}

        // Get the token
        $token = auth()->login($newUser);

        // Response
        if(!$token) {
            return response()->json(['message' => 'Success', 'data' => $newUser], 201);
        }
        else{
            return $this->respondToken($token, 201);
        }
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

}
<?php

namespace App\Http\Controllers;

// Dependencies
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Auth\Events\Registered;

// Models
use App\Models\User;

// Requests
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

// Exceptions
use App\Exceptions\BadRequestException;

class UserController extends Controller
{
    public function getAll() {
        $users = User::where('role', '!=', 'admin')->get();
        return response()->json(['message' => 'Success', 'data' => $users], 200);
    }

    public function getById($id) {
        $user = User::find($id);

        if(!isset($user)) throw new BadRequestException('User does not exist.');

        return response()->json(['message' => 'Success', 'data' => $user], 200);
    }

    public function create(UserCreateRequest $request) {
        // Exclude data from request
        $parameters = $request->safe()->only(['name', 'email', 'password', 'role']);

        // Hash password
        $parameters['password'] = Hash::make($parameters['password']);

        // Create in DB
        $user = User::create($parameters);

        // Fire registered event for email confirmation
		if(config('app.verify_email')) {
	        event(new Registered($user));
		}
		else{
			$user->markEmailAsVerified();
		}

        return response()->json(['message' => 'Success', 'data' => $user], 201);
    }

    public function update(UserUpdateRequest $request) {
        // Exclude data from request
        $parameters = $request->safe()->only(['id', 'name', 'email', 'password', 'role']);

        // Hash password
        if(isset($parameters['password'])) $parameters['password'] = Hash::make($parameters['password']);

        // Find user
        $user = User::find($parameters['id']);

        if(!isset($user)) throw new BadRequestException('User does not exist.');

        // Update in DB
        $user->fill($parameters)->save();

        return response()->json(['message' => 'Success', 'data' => $user], 200);
    }

    public function delete($id) {
        $user = User::find($id);

        if(!isset($user)) throw new BadRequestException('User does not exist.');

        $user->delete();

        return response()->json(['message' => 'Success'], 200);
    }
}
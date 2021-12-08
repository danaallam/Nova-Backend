<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        if($user->profile != null)
            $user->profile = $request->email;
        $user->save();
        $token = auth('user')->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('user')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('user')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('user')->factory()->getTTL() * 60,
            'user' => auth('user')->user()
        ]);
    }
}

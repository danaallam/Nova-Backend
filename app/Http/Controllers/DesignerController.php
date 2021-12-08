<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use Illuminate\Http\Request;

class DesignerController extends Controller

{
    public function register(Request $request)
    {
        $designer = new Designer();
        $designer->name = $request->name;
        $designer->email = $request->email;
        $designer->password = $request->password;
        $designer->profession = $request->profession;
        $designer->save();
        $token = auth('designer')->login($designer);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('designer')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('designer')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('designer')->factory()->getTTL() * 60,
            'designer' => auth('designer')->user()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignerRequest;
use App\Models\Designer;
use Illuminate\Http\Request;

class DesignerController extends Controller

{
    public function register(DesignerRequest $request)
    {
        $designer = new Designer();
        $designer->name = $request->name;
        if($request->file('profile') != null)
            $designer->profile = $request->file('profile')->store('designerProfile');
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
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('designer')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function checkToken(){
        return response()->json(['status' => 200, "user"=>auth('designer')->user()]);
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

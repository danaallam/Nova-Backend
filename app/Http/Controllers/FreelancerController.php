<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        if($request->file('profile') != null)
            $user->profile = $request->file('profile')->store('tailorProfile');
        $user->resume = null;
        $user->link = "";
        $user->experience = 0;
        $user->phone = "";
        $user->save();
        $token = auth('user')->login($user);
        return $this->respondWithToken($token);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setResume(Request $request){
        $user = User::where('id', auth('user')->user()->id)->first();
        $user->resume = $request->file('resume')->store('resume');
        $user->save();
        return response()->json(['message'=>'Resume saved', 'user'=>$user]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('user')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('user')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function checkToken(){
        return response()->json(['status' => 200, "user"=>auth('user')->user()]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user')->factory()->getTTL() * 60,
            'user' => auth('user')->user()
        ]);
    }

    public function getUsers(){
        $users = User::with('posts')->get();
        return response()->json(['status'=>200, 'users'=>$users]);
    }
}

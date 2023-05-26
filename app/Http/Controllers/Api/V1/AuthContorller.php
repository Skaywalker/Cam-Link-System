<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthContorller extends Controller
{
    public function login(Request $request)
    {
        $request= $request->only('email', 'password');

        if (Auth::attempt($request))
        {
            $user= Auth::user();
            if ($user->privilege=='customer'){
                $token=$user->createToken('Api Token ' . $user->privilege,['customer:wive','change:CameraName'])->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token
                ]);
            }
            if ($user->privilege=='installer'){
                $token=$user->createToken('Api Token ' . $user->privilege,['installer'])->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token
                ]);
            }
        }
            return response()->json(['errors' => 'Hibás email jelszó páros!'],401);

    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['alert'=>['type'=>'success','message'=>'Sikeres kijelentkezés!']]);
    }
    public function register(RegisterRequest $request){
        $request->validated($request->all());

        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'privilege'=>'customer',
            'password'=>Hash::make($request->password),
        ]);

        return response()->json(  ['user'=>$user]);

    }
}

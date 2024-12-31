<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){

        /* $data : القيم المرسلة من الفرونت */
        $data = $request->validate([
            'email' => 'required|string',
            'password' =>'required|string'
        ]);

        /* $user : المستخدم المخزن في قاعدة البيانات */
        $user = User::where('email',$data['email'])->first(); /* تحضر معلومات المستخدم كلها من خلال الايميل */

                     /* !Hash::check($value, $hashedValue) */
        if(!$user || !Hash::check( $data['password'], $user->password)){
            return response(['message'=>"incorrect email or password"],401);
        }

        $token = $user->createToken('apiToken')->plainTextToken;
        return response(['userName'=>$user->name,'token'=>$token] , 200);


    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
       /*  auth()->user()->currentAccessToken()->delete(); */
        return response(['Messsage'=>"Logout successfuly"] , 200);


    }
}

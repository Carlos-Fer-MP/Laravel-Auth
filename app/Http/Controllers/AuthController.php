<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    //

    public function signUp(Request $request){


        $request->validate([

            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'

        ]);
        
        /*
        if($request->fails){

            return response()->json($request->errors());


        }*/

        User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
        
        //
        return response()->json(['message' => 'Succesfully created user!'],201);

    }
    //
    public function login(Request $request){

        $request->validate([

         'email' => 'required|string|email',
         'password' => 'required|string',
         'remenber_me' => 'boolean'

        ]);
        
        //
        $credentials = request(['email','password']);
        
        //
        if(!Auth::attempt([$credentials])){

            return response()->json(['message' => 'Unauthorized'],401);

        }

        //
        $user = $request->user();
        $tokenResult = $user->createToken('Perosnal Access Token');

        $token = $tokenResult->token;

        //
        if($request->remenber_me){

            $token->expires_at = Carbon::now()->addWeeks(1);

        }
        $token->save();

        //
        return response()->json([

            'access_token' => $tokenResult->accessToken,
            'token_type' =>'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            
        ]);
    }

    //
    public function logout(Request $request){

        $request->user()->token()->revoke();
        
        return response()->json([

            'message' => 'Succesfully logged out'

        ]);

    }

    //
    public function user(Request $request){

        return response()->json([$request->user()]);
        
    }

}

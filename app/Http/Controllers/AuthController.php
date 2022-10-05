<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password']),


        ]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',

        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }

    //login


    public function login(Request $request)
    {

        //  return response()->json($request->all(), 422);
        // $validator = $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        // ]);


        return response()->json($request->email);
        $user = User::where('email', 'ezz@gmail.com')->first()->toArray();

        return response()->json($user);

        if ($user) {
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->createToken($request->email)->plainTextToken
            ]);
        } else {
            abort(404);
        }



        //logout

        function logout()
        {

            auth()->Auth::user()->tokens()->delete();

            return response([


                'message' => 'logout success.'
            ], 200);
        }

        function user()
        {

            return response([
                'user' => auth()->Auth::user()
            ], 200);
        }
    }


    public function login2(Request $request)
    {
        return response()->json($request->email);
    }
}

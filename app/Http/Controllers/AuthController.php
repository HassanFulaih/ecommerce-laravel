<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields =  $request-> validate([
            'phone_number'=> 'required|min:11|max:11|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users',
            'name'=> 'required',
            'governorate'=> 'required|string',
            'city'=> 'required|string',
            'password'=> 'required|string|min:6|confirmed',
        ]);
        $user =  User::create([
            'phone_number'=> $fields['phone_number'],
            'name'=> $fields['name'],
            'governorate'=> $fields['governorate'],
            'city'=> $fields['city'],
            'password'=> bcrypt($fields['password']),
        ]);

        $token = $user-> createToken('MyApp')-> plainTextToken;
        
        $response = [
            'user'=> $user,
            'token'=> $token,
        ];

        return response($response, 201); //201
    }

    public function update(Request $request, $id){
        // $fields =  $request-> validate([
        //     'phone_number'=> 'required|min:11|max:11|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users',
        //     'name'=> 'required',
        //     'governorate'=> 'required|string',
        //     'city'=> 'required|string',
        //     'password'=> 'required|string|min:6|confirmed',
        // ]);
        $user =  User::find($id);
        $user -> update($request->all());
        $user -> update([
            'password'=> bcrypt($request->password),
        ]);
        return $user;

    }

    public function login(Request $request){
        $fields =  $request-> validate([
            'phone_number'=> 'required|min:11|max:11|regex:/^([0-9\s\-\+\(\)]*)$/',
            'password'=> 'required|string|min:6',
        ]);
        $user =  User::where('phone_number', $fields['phone_number'])->first();

        if(!$user){
            return response([
                'message'=> 'Phone Number not found'
            ], 404); //Response::HTTP_NOT_FOUND
        }

        if(! Hash::check($fields['password'], $user-> password)){
            return response([
                'message'=> 'Password do not match!'
            ], 404); //Response::HTTP_NOT_FOUND
        }

        $token = $user-> createToken('MyApp')-> plainTextToken;
        
        $response = [
            'user'=> $user,
            'token'=> $token,
        ];

        return response($response, 201); //Response::HTTP_CREATED
    }

    public function destroy($id){

        auth()->user()->tokens()->delete();
        auth()->user()->delete();

        return [
            'message'=> 'Successfully Deleted'
        ];
    }

    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        return [
            'message'=> 'Logout Successfully'
        ];
    }
}

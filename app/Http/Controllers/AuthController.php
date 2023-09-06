<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function Register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);
        $token = $user->createToken('UserToken')->plainTextToken;
        return response()->json(['Token' => $token , 'user' => $user]);
    }

    public function Logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'],200);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        //check email and password
        $user = User::where('email',$fields['email'])->first();
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response()->json(['message'=> 'email or password not correct'],401);
        }

        $token = $user->createToken('UserToken')->plainTextToken;
        return response()->json(['Token' => $token , 'user' => $user]);
    }

    public function userRole(Request $request){
        $user = $request->user();
        $userRole = $user->type;
        return response()->json(['userRole'=> $userRole],200);
    }

    public function getUser(Request $request){
        $user = $request->user();
        return response()->json(['user'=> $user],200);
    }

    public function userProfile(Request $request){
        $user = $request->user();
        $userDetails = $user->userDetails;
        return response()->json(['userDetails' => $userDetails , 'user' => $user],200);
    }

    public function changePw(Request $request){
        $user = $request->user();
        $current_pw = $request->current_password;
        if(Hash::check($current_pw, $user->password)){
            $fields = $request->validate([
                'new_password' => 'required|string|confirmed',
            ]);
            $user->update([
                'password' => bcrypt($fields['password']),
            ]);
            return response()->json(['message'=> 'password changed successfully'],200);
        }
        else{
            return response()->json(['message'=> 'Current Password Incorrect'],401);
        }
    }

    public function createProfile(Request $request){
        $user = $request->user();
        $fields = $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'location_link' => 'string',
            'gender' => 'string',
            'state' => 'required|string',
            'zip_code' => 'string',
            'phone' => 'required|string|unique:user_details,phone',
        ]);
        $userDetails = UserDetail::create([
            'user_id' => $user->id,
            'address' => $fields['address'],
            'city' => $fields['city'],
            'state' => $fields['state'],
            'zip_code' => $fields['zip_code'],
            'phone' => $fields['phone'],
            'gender' => $fields['gender'],
            'location_link' =>  $fields['location_link'],
        ]);
        return response()->json(['userDetails' => $userDetails]);
    }

    public function updateProfile(Request $request){
        $user = $request->user();
        $userDetails = $user->userDetails;
        $fields = $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'location_link' => 'string',
            'gender' => 'string',
            'state' => 'required|string',
            'zip_code' => 'string',
            'phone' => ['required','string',Rule::unique('user_details')->ignore($userDetails->id)],
        ]);
        $userDetails->update($fields);
        return response()->json(['userDetails' => $userDetails]);
    }
}

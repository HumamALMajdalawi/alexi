<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class AuthController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;

            return response()->json([
                'success' => 'true',
                'response' => "Success",
                'redirect' => "/",
                'token' => $success['token'],
                'role_id' => $user->role_id,
                'messages' => "ok"], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|between:4,60',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|between:6,25|same:confirmPassword',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['name'] = $input['fullName'];
        $input['role_id'] = 4;
        $user = User::create($input);
        // $user->roles()->attach(Role::where('name', 'Developer')->first());

        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json([
            'success' => 'true',
            'response' => "Success",
            'redirect' => "/",
            'token' => $success['token'],
            'messages' => "ok"], $this->successStatus);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->update(['revoked' => true]);
            return response()->json(['success' => true], $this->successStatus);
        }
        return response()->json(['success' => false], $this->successStatus);
    }

}

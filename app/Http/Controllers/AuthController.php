<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    use CommonTrait;

    public function login(Request $request)
    {
        try {
            $validators = Validator($request->all(), [
                'email' => 'required|exists:users,email',
                'password' => 'required',
            ]);
            if ($validators->fails()) {
                return $this->sendError($validators->messages(), null);
            }

            $user = User::with('roles')->where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'error' => 'Invalid login details'
                ], 401);
            }
            $token = $user->createToken('myapptoken')->plainTextToken;
            $user->makeHidden(['password','remember_token']);
            $user['token']=$token;

            return $this->sendSuccess("success", $user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }

    public function register(Request $request)
    {
        try {
            $validators = Validator($request->all(), [
                'name'=>'required|max:100|string',
                'email' => 'required|unique:users,email',
                'password' => 'required',
            ]);
            if ($validators->fails()) {
                return $this->sendError($validators->messages(), null);
            }

            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->email),
            ]);
            $user->assignRole('user');
            $token = $user->createToken('myapptoken')->plainTextToken;
            $user->makeHidden(['password','remember_token']);
            $user['token']=$token;
            $user['roles']=$user->roles;
            $user['image']=null;
            return $this->sendSuccess("success", $user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();

            return $this->sendSuccess('Tokens Revoked', true);

        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }


    }
    public function nameUpdate(Request $request)
    {
        try {
            $validators = Validator($request->all(), [
                'name' => 'required',
            ]);
            if ($validators->fails()) {
                return $this->sendError($validators->messages(), null);
            }

            $user = User::find(Auth::id());
            if ($user){
                $user->update(['name'=>$request->name]);
            }
            return $this->sendSuccess('success', $user);
        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }

    public function passwordUpdate(Request $request)
    {
        try {
            $validators = Validator($request->all(), [
                'password' => 'required|min:6|confirmed',
            ]);
            if ($validators->fails()) {
                return $this->sendError($validators->messages(), null);
            }

            $user = User::find(Auth::id());
            if ($user){
                $user->update(['password'=>Hash::make($request->password)]);
            }
            return $this->sendSuccess('success', $user);
        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }

    public function userInfo()
    {
        try {
            $user = User::find(Auth::id());
            if ($user){
                return $this->sendSuccess('success', $user);
            }
            return $this->sendError('not found',422);

        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }

    public function profileUpdate(Request $request)
    {
        try {
            $validators = Validator($request->all(), [
                'image' => 'required|image|mimes:jpg,jpeg,png,gif',
            ]);
            if ($validators->fails()) {
                return $this->sendError($validators->messages(), null);
            }
            $user = User::find(Auth::id());
            if ($user){
                if ($user->image){
                    if (Storage::exists('public/' . $user->image)) {
                        unlink(storage_path('app/public/' . $user->image));
                    }
                }
                $path = request()->file('image')->store('profile', 'public');
                $user->update(['image'=>$path]);
                return $this->sendSuccess('success', $user);
            }
            return $this->sendError('not found',422);

        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }
}

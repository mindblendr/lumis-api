<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
	public function login(Request $request)
	{
		try {
			$creds = $request->only(['email', 'password']);
			$user = User::where('email', $creds['email'])->first();

			if ($user && Hash::check($creds['password'], $user->password)) {
				$token = auth()->login($user);
				return response()->json(['token' => $token]);
			}

			return response()->json(['error' => 'Invalid credentials']);
		} catch (\Tymon\JWTAuth\Exceptions\JWTException $th) {
			return response()->json(['error' => $th->getMessage()]);
		}
	}
}

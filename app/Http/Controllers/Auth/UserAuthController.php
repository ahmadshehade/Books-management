<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|confirmed|min:6|max:16",
            "name" => "required|alpha|min:3|max:20",

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $user = User::create([
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "name" => $request->name
        ]);

        return redirect()->route('loginPage')->with("success", "Successfully Registered");
    }


    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only("email", "password");

        if (auth('web')->attempt( $credentials)) {

            $request->session()->regenerate(); // لحماية الجلسة من اختطاف الجلسة

            return redirect()->route('books.index')->with("success", "Successfully Logged In");
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        auth('web')->logout();
        $request->session()->invalidate(); // إنهاء الجلسة القديمة
        $request->session()->regenerateToken(); // توليد token جديد
        return redirect()->route('loginPage')->with('success', 'Successfully Logout');
    }
}


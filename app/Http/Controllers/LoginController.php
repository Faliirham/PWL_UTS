<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $rules = [
            'username' => 'required|min:4|max:20',
            'password' => 'required|min:6|max:20',
        ];

        $messages = [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ];

        $validator = Validator::make($credentials, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors(),
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil!',
                'redirect' => route('dashboard') // ganti route sesuai dengan dashboard kamu
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Username atau password salah!',
            'msgField' => [
                'username' => [''],
                'password' => ['']
            ]
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

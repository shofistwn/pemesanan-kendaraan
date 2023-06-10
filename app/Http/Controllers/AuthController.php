<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function loginForm()
  {
    return view('pages.auth.login');
  }
  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      $user = Auth::user();

      if ($user->role === 'admin') {
        return redirect()->route('admin.index');
      } elseif ($user->role === 'regional_manager') {
        return response()->json('regional');
        // return redirect()->route('regional.dashboard');
      } elseif ($user->role === 'branch_manager') {
        return response()->json('branch');
        // return redirect()->route('branch.dashboard');
      }
    }
    return back()->with('error', 'Email or password are incorrect!');
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('login');
  }
}
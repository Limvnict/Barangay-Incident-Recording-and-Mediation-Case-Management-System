<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function showLogin() { return view('auth.login'); }

    public function login(Request $r) {
        $cred = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (! Auth::attempt($cred, $r->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }
        $r->session()->regenerate();
        return redirect('/');
    }

    public function showRegister() { return view('auth.register'); }

    public function register(Request $r) {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'regex:/^09[0-9]{9}$/'],
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create($data + ['role' => 'resident']); // public signup is always a resident
        Auth::login($user);
        $r->session()->regenerate();
        return redirect('/');
    }

    public function logout(Request $r) {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleModel as Role;
use App\Models\PermissionModel as Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        $data['title'] = 'Login';
        return view('login', ['data' => $data]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->hasRole('UAdmin')) {
                return redirect()->intended('/back/program');
            } else if ($user->hasRole('Kontributor')) {
                return redirect()->intended('/back/program');
            } else if ($user->hasRole('Santri')) {
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'password' => 'Wrong username or password',
        ]);
    }

    public function register()
    {
        $data['title'] = 'Login';
        return view('register', ['data' => $data]);
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $role = Role::where('name', 'Santri')->first();

        $users = new User([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($users->save() && $users->syncRoles($role->id)) {
            return redirect()->route('login')->with('success', 'Registration success. Please login!');
        }
        return back()->withErrors([
            'error' => 'Wrong username or password',
        ]);
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\User\LoginRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\User\RegisterRequest;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.pages.login');
    }

    public function do_login(LoginRequest $request): RedirectResponse
    {
        $username = $request->username;
        $password = $request->password;

        $fieldType = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $username)
            ->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                if ($user->status == UserStatusType::Blocked) {
                    Alert::toast(__('Your account has been blocked. Please contact the administrator for further information.'), 'error');
                    return back()
                        ->withInput();
                }

                Auth::login($user, $request->has('remember_me'));

                $request->session()
                    ->regenerate();

                if (Auth::user()->role_name == 'User')
                    return to_route('reservation');

                return to_route('dashboard.home');
            }

            Alert::toast(__('Wrong Authentication.'), 'warning');
            return back()
                ->withInput();
        }

        Alert::warning(__('Attention!'), __('No user found.'));

        return back()
            ->withInput();
    }

    public function register(): View
    {
        return view('auth.pages.register');
    }

    public function do_register(RegisterRequest $request): RedirectResponse
    {
        $new_user = new User();
        $new_user->username = $request->username;
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->save();

        $new_user->assignRole('User');

        Alert::toast(__('The :feature was successfully registered.', ['feature' => __('User')]), 'success');
        return to_route('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login');
    }
}

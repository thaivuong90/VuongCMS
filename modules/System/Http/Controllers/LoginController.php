<?php

namespace VuongCMS\System\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use VuongCMS\System\Models\System;
use VuongCMS\System\Models\Account;

class LoginController extends Controller
{
  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    if ($request->isMethod('post')) {

      $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        'system_id' => ['required']
      ]);

      if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended(system_route('system.dashboard'));
      }

      return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
      ]);
    }
    return view('system::login', ['system_id' => $request->system_id]);
  }

  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function forgotPassword(Request $request)
  {
    $data = [];
    if ($request->isMethod('post')) {

      $credentials = $request->validate([
        'email' => ['required', 'email'],
      ]);

      $system = System::where('slug', $request->route('slug'))->where('email', $credentials['email'])->first();
      if ($system) {
        $account = Account::where('system_id', $system->getKey())->where('email', $credentials['email'])->first();
        $account->password = Hash::make(Str::random(8));
        $account->save();
        $data = [
          'message' => trans('common.message.update_password_ok'),
          'type' => 'success'
        ];
      } else {
        $data = [
          'message' => trans('common.message.update_password_error'),
          'type' => 'danger'
        ];
      }
    }
    return view('system::forgotPassword', $data);
  }

  /**
   * logout
   */
  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect(system_route('system.login'));
  }
}

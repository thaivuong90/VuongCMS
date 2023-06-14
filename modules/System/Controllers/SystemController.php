<?php

namespace VuongCMS\System\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use VuongCMS\Common\Models\Account;
use VuongCMS\Common\Models\System;

class SystemController extends Controller
{

  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('system::dashboard');
  }

  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('system::create');
  }

  /**
   * confirmation.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function confirmation(Request $request)
  {
    $email = $request->old('email', '');
    return view('system::confirmation', ['email' => $email]);
  }

  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    DB::beginTransaction();
    try {
      $validated = $request->validate([
        'name' => 'required',
        'url' => 'required',
        'email' => 'required|unique:systems',
        'cccd' => 'required',
        'phone' => 'required',
        'username' => 'required',
        'password' => 'required|confirmed',
      ]);

      $validated['expired_in'] = date('Y-m-d H:i:s');
      $validated['status'] = System::NOT_CONFIRM;

      $system = new System($validated);
      $system->save();

      if ($system) {
        $user = new Account([
          'name' => 'Admin Of ' . $validated['name'],
          'email' => $validated['email'],
          'password' => bcrypt($validated['password']),
          'system_id' => $system->getKey(),
        ]);
        $user->save();
      }
      
      DB::commit();
      return redirect(route('system.confirmation'))->withInput(['email' => $validated['email']]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e);
      return redirect()->back();
    }
  }

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
   * logout
   */
  public function logout(Request $request) {
    Auth::logout();

    $request->session()->invalidate();
 
    $request->session()->regenerateToken();

    return redirect(system_route('system.login'));
  }
}

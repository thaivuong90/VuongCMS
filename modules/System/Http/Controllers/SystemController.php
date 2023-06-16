<?php

namespace VuongCMS\System\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use VuongCMS\System\Models\Account;
use VuongCMS\System\Models\System;
use VuongCMS\System\Models\Scopes\ActiveScope;

class SystemController extends Controller
{

  /**
   * index
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('system::dashboard');
  }

  /**
   * create
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
    if ($request->route('token')) {
      return $this->activate($request->route('token'));
    }
    $email = $request->old('email', '');
    if (!$email) return abort(404);
    return view('system::confirmation', ['email' => $email]);
  }

  /**
   * resend.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function resend(Request $request)
  {
    if ($request->isMethod('post')) {
      $credentials = $request->validate([
        'email' => ['required', 'email'],
      ]);
      $system = System::where('email', $credentials['email'])->withoutGlobalScope(ActiveScope::class)->first();
      if (!$system) return abort(404);
      $system->token = Str::random(100);
      $system->expired_in = Carbon::now()->addMinutes(5);
      $system->status = ActiveScope::NOT_CONFIRM;
      $system->save();
      // Send resend mail
      return redirect()->route('system.confirmation')->withInput(['email' => $request->input('email')]);
    }
    return view('system::resend');
  }

  /**
   * store
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|max:255',
      'slug' => 'required|max:255',
      'email' => 'required|unique:systems|max:255',
      'cccd' => 'required|max:20',
      'phone' => 'required|max:20',
      'address' => 'required|max:255',
      'username' => 'required|max:255',
      'password' => 'required|confirmed',
      'logo' => 'image|max:524288'
    ]);

    DB::beginTransaction();
    try {
      $validated['token'] = Str::random(100);
      $validated['expired_in'] = Carbon::now()->addMinutes(5);
      $validated['status'] = ActiveScope::NOT_CONFIRM;

      if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $validated['logo'] = Storage::putFile('public', $file);
      }

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
   * activate
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function activate($token)
  {
    DB::beginTransaction();
    try {
      $system = System::where('token', $token)->where('expired_in', '>', now())->withoutGlobalScope(ActiveScope::class)->first();
      if ($system) {
        $system->status = ActiveScope::ACTIVE;
        $system->token = null;
        $system->expired_in = null;
        $system->confirmed_at = Carbon::now();
        $system->save();
        DB::commit();
        return view('system::alert', [
          'type' => 'success',
          'message' => trans('common.message.activate_ok'),
          'title' => trans('common.title.success'),
          'slug' => $system->slug,
        ]);
      }
      return view('system::alert', [
        'type' => 'danger', 
        'message' => trans('common.message.activate_error'),
        'title' => trans('common.title.error')
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e);
      return redirect()->back();
    }
  }
}

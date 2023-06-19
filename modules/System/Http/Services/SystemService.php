<?php

namespace VuongCMS\System\Http\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use VuongCMS\System\Http\Interfaces\SystemInterface;
use VuongCMS\Shared\Models\System;
use VuongCMS\Shared\Models\Account;
use VuongCMS\Shared\Models\Scopes\ActiveScope;

class SystemService implements SystemInterface
{
  /**
   * index
   */
  public function index()
  {
    return view('system::dashboard');
  }

  /**
   * create
   */
  public function create()
  {
    return view('system::create');
  }

  /**
   * store
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
   * confirmation
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
   * activate
   */
  public function activate($params)
  {
    DB::beginTransaction();
    try {
      $system = System::where('token', $params['token'])->where('expired_in', '>', now())->withoutGlobalScope(ActiveScope::class)->first();
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

  /**
   * resend
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
}

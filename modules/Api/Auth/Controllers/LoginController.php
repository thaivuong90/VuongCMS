<?php

namespace VuongCMS\Api\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use VuongCMS\System\Models\Account;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
  /**
   * index
   */
  public function index(Request $request)
  {
    if ($request->isMethod('post')) {
      $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
      ]);

      if (!Auth::attempt($credentials)) {
        throw ValidationException::withMessages([
          'email' => ['The provided credentials are incorrect.'],
        ]);
      }

      $account = Account::where('email', $credentials['email'])->first();
      $token = $account->createToken($request->email)->plainTextToken;
      return response()->json([
        'token' => $token,
      ], 200);
    }
    
  }

  /**
   * show
   */
  public function show($id)
  {
    return response()->json([$id], 200);
  }
}

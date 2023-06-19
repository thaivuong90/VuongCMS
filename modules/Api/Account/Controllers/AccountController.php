<?php

namespace VuongCMS\Api\Account\Controllers;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
  /**
   * index
   */
  public function index() {
    return response()->json([
      'message' => 'Account Info',
    ], 200);
  }
}

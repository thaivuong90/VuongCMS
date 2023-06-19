<?php

namespace VuongCMS\System\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use VuongCMS\System\Http\Interfaces\SystemInterface;

class SystemController extends Controller
{
  private $service;

  public function __construct(SystemInterface $systemService)
  {
    $this->service = $systemService;
  }
  /**
   * index
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->service->index();
  }

  /**
   * create
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return $this->service->create();
  }

  /**
   * confirmation.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function confirmation(Request $request)
  {
    return $this->service->confirmation($request);
  }

  /**
   * resend.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function resend(Request $request)
  {
    return $this->service->resend($request);
  }

  /**
   * store
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    return $this->service->store($request);
  }

  /**
   * activate
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function activate($token)
  {
    return $this->service->activate(['token' => $token]);
  }
}

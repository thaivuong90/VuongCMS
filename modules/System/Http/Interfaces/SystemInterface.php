<?php
namespace VuongCMS\System\Http\Interfaces;

use Illuminate\Http\Request;

interface SystemInterface
{
    public function index();
    public function create();
    public function store(Request $request);
    public function confirmation(Request $request);
    public function activate($params);
    public function resend(Request $request);
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify.admin');
    }

    public function index()
    {
        return view('admin.index');
    }
}

<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    function __construct()
    {
        $this->middleware('banned');
        $this->middleware('auth');
        $this->middleware('moderator');
    }

    public function index()
    {
        return view('admin.main');
    }
}

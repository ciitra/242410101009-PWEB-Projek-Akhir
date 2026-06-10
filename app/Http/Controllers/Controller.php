<?php

namespace App\Http\Controllers;

Use Illuminate\Http\Request;

abstract class Controller
{
    public function index ()
    {
        return view('dashboard');
    }
}


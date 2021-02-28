<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetaiController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.frontend.detail');
    }
}

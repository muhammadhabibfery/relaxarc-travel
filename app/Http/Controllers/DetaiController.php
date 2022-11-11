<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetaiController extends Controller
{

    /**
     * Show the detail travel
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.frontend.detail');
    }
}

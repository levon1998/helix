<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     *  Function to render index page
     *
     * @return view
     */
    public function index()
    {
        return view('layouts.user.pages.index');
    }
}

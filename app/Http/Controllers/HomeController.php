<?php

namespace App\Http\Controllers;

use App\Feed;

class HomeController extends Controller
{
    /**
     * Index Home
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('home', ['feeds' => (new Feed)->getAllWithItems()]);
    }
}

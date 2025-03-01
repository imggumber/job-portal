<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view("front.home");
    }

    public function contact()
    {
        return view("front.contact");
    }
}

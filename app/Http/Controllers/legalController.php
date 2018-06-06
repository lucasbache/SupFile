<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class legalController extends Controller
{
    public function index(){
        return view('legal');
        // controller
    }
}
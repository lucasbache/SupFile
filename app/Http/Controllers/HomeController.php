<?php

namespace App\Http\Controllers;

use App\repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userepo = repository::findById($user->id);
        $cheminActuel = 'storage/'.$user->email.'/';
        session()->put('cheminActuel',$cheminActuel);
        return view('home',compact('userepo'));
    }

    public function profil()
    {
        return view('profil');
    }
}

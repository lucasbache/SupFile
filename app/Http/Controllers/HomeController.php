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
        //On récupère les infos utilisateurs
        $user = Auth::user();

        //On recherche les dossiers et fichiers à afficher
        $userepo = repository::findRepoById($user->id);

        //On crée le chemin du dossier actuel et on le met en session
        $dossierActuel = 'storage/'.$user->email.'/';
        session()->put('dossierActuel',$dossierActuel);

        return view('home',compact('userepo'));
    }

    public function profil()
    {
        return view('profil');
    }
}

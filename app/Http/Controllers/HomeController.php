<?php

namespace App\Http\Controllers;

use App\repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\fileEntries;

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
        $userepo = repository::findRepoByUserId($user->id);
        $userFile = fileEntries::findFileByUserId($user->id);

        foreach ($userepo as $repo)
        {
            if($repo->cheminDossier == $user->email){
                $dossierActuel = $repo;
            }
        }
        $nomDossierActuel = $dossierActuel->cheminDossier;

        return view('home',compact('userepo','dossierActuel','userFile','nomDossierActuel'));
    }

    public function profil()
    {
        return view('profil');
    }
}

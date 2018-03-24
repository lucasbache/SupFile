<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class afficherDossier extends Controller
{
    public function index()
    {
        $dossierPrec = session()->get('cheminActuel');
        //$dossierActuel =
        return view('repertoire');
    }
}

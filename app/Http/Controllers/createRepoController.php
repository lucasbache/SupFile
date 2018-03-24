<?php

namespace App\Http\Controllers;
use App\Http\Requests\createRepoRequest;
use App\repository;
use File;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class createRepoController extends Controller
{
    public function repoForm()
    {
        return view('createRepo');
    }

    public function repoSubmit(createRepoRequest $request)
    {
        //On recherche les infos utilisateur
        $user = Auth::user();

        //On récupère le nom du dossier et on crée le chemin du dossier qui va être crée
        $repoName = $request->input('name');
        $cheminDossier = session()->get('dossierActuel').$repoName.'/';

        //On crée le dossier
        $dossier = repository::create([
            'user_id' => $user->id,
            'name' => $repoName,
            'dossierPrimaire' => 'N',
            'cheminDossier' => $cheminDossier,
            'dossierParent' => session()->get('dossierActuel')
        ]);
        File::makeDirectory($dossier->dossierParent.'/'.$repoName.'/', 0777, true);

        return redirect('home')->with("success", "Le répertoire a bien été crée");
    }


}

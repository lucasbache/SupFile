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
        $userId = $user->id;

        //On récupère le nom du dossier et on crée le chemin du dossier qui va être crée
        $repoName = $request->input('name');
        $cheminDossier = session()->get('dossierActuel').$repoName.'/';

        $dossierActuel = session()->get('dossierActuel');

        $this->createrepo($userId, $repoName, $cheminDossier, $dossierActuel);

        return redirect('home')->with("success", "Le répertoire a bien été crée");
    }

    public function createrepo($userId, $repoName, $cheminDossier, $dossierActuel){
        //On crée le dossier
        $dossier = repository::create([
            'user_id' => $userId,
            'name' => $repoName,
            'dossierPrimaire' => 'N',
            'cheminDossier' => $cheminDossier,
            'dossierParent' => $dossierActuel
        ]);
        File::makeDirectory($dossier->dossierParent.'/'.$repoName.'/', 0777, true);
    }


}

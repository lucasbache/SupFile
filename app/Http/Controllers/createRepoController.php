<?php

namespace App\Http\Controllers;
use App\Http\Requests\createRepoRequest;
use App\repository;
use File;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileTrait;

use Illuminate\Http\Request;

class createRepoController extends Controller
{
    use FileTrait;

    public function repoForm($id)
    {
        $repo = repository::findRepoById($id);
        $repoPath = $repo->cheminDossier;
        return view('createRepo',compact('repoPath'));
    }

    public function repoSubmit(createRepoRequest $request)
    {
        //On recherche les infos utilisateur
        $user = Auth::user();
        $userId = $user->id;

        //On récupère le nom du dossier et on crée le chemin du dossier qui va être crée
        $repoName = $request->input('name');
        $cheminDossier = $request->input('path').'/'.$repoName;

        $dossierActuel = $request->input('path');

        $this->createrepo($userId, $repoName, $cheminDossier, $dossierActuel);

        return redirect('home')->with("success", "Le répertoire a bien été crée");
    }


}

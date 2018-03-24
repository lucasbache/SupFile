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
        $user = Auth::user();
        $repoName = $request->input('name');
        $cheminDossier = session()->get('cheminActuel').$repoName.'/';
        repository::create([
            'user_id' => $user->id,
            'name' => $repoName,
            'dossierPrimaire' => 'N',
            'cheminDossier' => $cheminDossier,
            'dossierParent' => session()->get('cheminActuel')
        ]);
        File::makeDirectory('storage/'.$user->email.'/'.$repoName.'/', 0777, true);

        return redirect('home')->with("success", "Le répertoire a bien été crée");
    }


}

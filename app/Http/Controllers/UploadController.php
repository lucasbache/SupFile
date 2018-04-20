<?php

namespace App\Http\Controllers;

use App\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    use FileTrait;

    public function uploadForm()
    {
        return view('upload');
    }

    public function uploadSubmit(UploadRequest $request)
    {
        if ($request != null) {
            foreach ($request->photos as $file) {
                //On récupère les informations de l'utilisateur
                $user = Auth::user();
                $userId = $user->id;

                //On prépare le dossier dans lequel va être stocké le fichier
                $dossierActuel = session()->get('dossierActuel');

                //On récupère le nom du fichier
                $nomFicComplet = $_FILES['photos']['name'][0];

                $this->uploadFile($userId, $dossierActuel, $file, $nomFicComplet);
            }

            return redirect()->action('afficherDossier@index')->with("success", "Le fichier a bien été envoyé !");
        }
        else{
            return redirect()->action('afficherDossier@index')->with("error", "Aucun fichier n'a été sélectionné !");
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\repository;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Storage;

class DownloadController extends Controller
{

    use FileTrait;

    public function downloadFile($filename,$idDossier)
    {
        $user = Auth::user();
        $dossierActuel = repository::findRepoById($idDossier);
        $dossierFichier = $dossierActuel->dossierParent.'/'.$dossierActuel->name;
        //dd($dossierFichier);

        return $this->downloadFiles($user->email, $dossierFichier, $filename);

    }

    public function downloadRepo($idDossier)
    {
        $repertoire = repository::findRepoById($idDossier);
        return $this->downloadRepos($repertoire);
    }
}

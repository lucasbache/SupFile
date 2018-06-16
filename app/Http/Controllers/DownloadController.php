<?php

namespace App\Http\Controllers;
use App\fileEntries;
use App\repository;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Crypt;

class DownloadController extends Controller
{

    use FileTrait;

    public function downloadFile($fileId)
    {
        $file = fileEntries::findFileById($fileId)->first();
        $filename = $file->cheminFichier;

        return $this->downloadFiles($filename);
    }

    public function downloadFilePublic($fileId)
    {
        $decryptedId = Crypt::decryptString($fileId);
        $file = fileEntries::findFileById($decryptedId)->first();
        $filename = $file->cheminFichier;

        return $this->downloadFiles($filename);
    }

    public function downloadRepo($idDossier)
    {
        $repertoire = repository::findRepoById($idDossier);

        return $this->downloadRepos($repertoire);
    }

    public function downloadRepoPublic($idDossier)
    {
        $decryptedId = Crypt::decryptString($idDossier);
        $repertoire = repository::findRepoById($decryptedId);

        return $this->downloadRepos($repertoire);
    }
}

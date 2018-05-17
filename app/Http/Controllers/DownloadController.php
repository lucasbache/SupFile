<?php

namespace App\Http\Controllers;
use App\fileEntries;
use App\repository;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Storage;

class DownloadController extends Controller
{

    use FileTrait;

    public function downloadFile($fileId)
    {
        $file = fileEntries::findFileById($fileId)->first();
        $filename = $file->cheminFichier;

        return $this->downloadFiles($filename);

    }

    public function downloadRepo($idDossier)
    {
        $repertoire = repository::findRepoById($idDossier);
        return $this->downloadRepos($repertoire);
    }
}

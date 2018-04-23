<?php

namespace App\Http\Controllers;
use App\Traits\FileTrait;

class DownloadController extends Controller
{

    use FileTrait;

    public function download($filename,$dossierFichier)
    {
        $user = Auth::user();

        $cheminPoint = explode('.', $dossierFichier);
        array_unshift($cheminPoint, $user->email);
        $dossierActuel = implode('/', $cheminPoint);
        dd($dossierActuel);
        $fileDownload = $dossierActuel.'/'.$filename;

        $this->downloadFile($fileDownload);
    }
}

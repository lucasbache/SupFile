<?php

namespace App\Http\Controllers;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Storage;

class DownloadController extends Controller
{

    use FileTrait;

    public function download($filename,$dossierFichier)
    {
        $user = Auth::user();

        $cheminPoint = explode('.', $dossierFichier);
        array_unshift($cheminPoint, $user->email);
        $dossierActuel = implode('/', $cheminPoint);

        $fileDownload = $dossierActuel.'/'.$filename;

        return Storage::download($fileDownload);
        //$this->downloadFile($fileDownload);
    }
}

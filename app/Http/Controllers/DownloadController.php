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
        $email = Auth::user()->email;

        //return Storage::download($fileDownload);
        return $this->downloadFile($filename,$dossierFichier, $email);
    }
}

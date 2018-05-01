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

        return $this->downloadFile($user->email, $dossierFichier, $filename);
    }
}

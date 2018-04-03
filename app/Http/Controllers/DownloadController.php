<?php

namespace App\Http\Controllers;

use Storage;

class DownloadController extends Controller
{
    public function download($filename)
    {
        $fileDownload = session()->get('dossierActuel').$filename.'/';
        return Storage::download($fileDownload);
    }
}

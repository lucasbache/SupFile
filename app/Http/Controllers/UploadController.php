<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\fileEntries;

class UploadController extends Controller
{
    public function uploadForm()
    {
        return view('upload');
    }

    public function uploadSubmit(UploadRequest $request)
    {
        if ($request != null) {
            foreach ($request->photos as $photo) {
                $filepath = $photo->store('photos');
                fileEntries::create([
                    'filename' => $request->input('name'),
                    'filepath' => $filepath
                ]);
            }

            return redirect()->back()->with("success", "Le fichier a bien été envoyé !");
        }
        else{
            return redirect()->back()->with("failed", "Aucun fichier n'a été sélectionné !");
        }
    }
}

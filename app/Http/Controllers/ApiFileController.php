<?php

namespace App\Http\Controllers;

use App\repository;
use App\fileEntries;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiFileController extends Controller
{
    use FileTrait;

    public function upload(Request $request){
        $dossierActuel = $request['path'];
        $file = $request['file'];
        $nomFicComplet = $request['filename'];
        $uid = $request->user()->id;

        if(strlen($uid)==0 || strlen($dossierActuel)==0 || strlen($file)==0 || strlen($nomFicComplet)==0){
            return json_encode(array('error' => 'missing parameters'));
        }
        else
        {
            if($dossierActuel == "root"){
                $dossierActuel = $request->user()->email;
            }else{
                $dossierActuel = $request->user()->email."/".$dossierActuel;
            }

            $this->uploadFile($uid, $dossierActuel, $file, $nomFicComplet);
            return json_encode(array('success' => 'file upload successful'));
        }
    }

    public function repoCreate(Request $request){

        $uid = $request->user()->id;
        $parentpath = $request['path'];
        $repoName = $request['name'];


        if(strlen($uid)==0 || strlen($parentpath)==0 || strlen($repoName)==0){
            return json_encode(array('error' => 'missing parameters'));
        }
        else
        {
            if($parentpath == "root"){
                $parentpath = $request->user()->email;
            }else{
                $parentpath = $request->user()->email."/".$parentpath;
            }

            $cheminDossier = $parentpath.'/'.$repoName;

            $this->createRepo($uid, $repoName, $cheminDossier, $parentpath);
            return json_encode(array('success' => 'repository successfully created'));
        }
    }

    public function downloadFileApi(Request $request){
        $filename = $request['filename'];
        $folder = $request['path'];
        $email = $request->user()->email;

        if($folder == "root"){
            $folder = $request->user()->email;
        }else {
            $folder = $request->user()->email."/".$folder;
        }

        return $this->downloadFiles($email, $folder, $filename);
    }

    public function listFiles(Request $request){
        $path = $request['path'];

        if(strlen($path)==0 ) {
            return json_encode(array('error' => 'missing parameters'));
        }
        else
        {
            if($path == "root") {
                $path = $request->user()->email;
            }else{
                $path = $request->user()->email."/".$path;
            }
            $repodata = [];
            $filedata = [];
            $testrepo = repository::findRepoByPath($path);

            if($testrepo == null){
                return json_encode(array('error' => 'folder not found'));
            }else {
                $repo = repository::findRepoByPathMulti($path);
                $files = fileEntries::findFileByRepo($path);

                foreach ($repo as $r) {
                    if ($r->user_id == $request->user()->id) {
                        array_push($repodata, $r->name);
                    }
                }
                foreach ($files as $f) {
                    if ($r->user_id == $request->user()->id) {
                        array_push($filedata, $f->name);
                    }
                }
                $data = array("folders" => $repodata, "files" => $filedata);

                return json_encode($data);
            }
        }
    }

    public function apiRenameRepo(Request $request)
    {
        $path = $request['path'];
        $newname = $request['name'];

        if (strlen($path) == 0 || strlen($newname) == 0) {
            return json_encode(array('error' => 'missing parameters'));
        }

        if($path == "root"){
            $path = $request->user()->email;
        }else {
            $path = $request->user()->email."/".$path;
        }

        $repo = repository::findRepoByPath($path);
        if ($repo == null) {
            return json_encode(array('error' => 'folder not found'));
        } else{
            $this->renameRepo($repo->id, $newname);
            return json_encode(array('success' => 'folder renamed successfully'));
        }
    }

    public function apiRenameFile(Request $request)
    {
        $path = $request['path'];
        $newname = $request['name'];

        if (strlen($path) == 0 || strlen($newname) == 0) {
            return json_encode(array('error' => 'missing parameters'));
        }

        if($path == "root"){
            $path = $request->user()->email;
        }else {
            $path = $request->user()->email."/".$path;
        }

        $file = fileEntries::findFileByPath($path)->first();
        if ($file == null) {
            return json_encode(array('error' => 'file not found'));
        } else{
            $this->renameFiles($file->id, $newname);

            return json_encode(array('success' => 'file renamed successfully'));
        }
    }

    public function apiDeleteFile(Request $request){
        $type = $request['type'];
        $path = $request['path'];

        if (strlen($type) == 0 || strlen($path) == 0) {
            return json_encode(array('error' => 'missing parameters'));
        }

        if($path == "root"){
            $path = $request->user()->email;
        }else {
            $path = $request->user()->email."/".$path;
        }

        if($type == "repo"){
            $repo = repository::findRepoByPath($path);
            $this->suppress("D", $repo->id);
            return json_encode(array('success' => 'folder successfully deleted'));

        }elseif ($type == "file"){
            $file = fileEntries::findFileByPath($path)->first();
            $this->suppress("F", $file->id);
            return json_encode(array('success' => 'file successfully deleted'));
        }else {
            return json_encode(array('error' => 'wrong file type'));
        }
    }
}

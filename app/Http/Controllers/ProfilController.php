<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\stockage;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $stkgUsr = stockage::findSizeByUserId($user->id)->first();

        $stockageUser = round((30000000000 - $stkgUsr->stockageUtilise) / 1000000000);

        $arrondiStockage = round($stockageUser ,0);
        $pourcentageStockage = round($stockageUser,0)/3*10;

        return view('profil', compact('arrondiStockage','pourcentageStockage'));
    }

    public function postAuth(Request $request)
    {
        //check which submit was clicked on
        if(Input::get('info')) {
            $ret = $this->changeInfo($request);
            if ($ret == 1){
                return redirect()->back()->with("success","Pseudo modifié");
            }
        } elseif(Input::get('password')) {
            $ret = $this->changePassword($request);
            if ($ret == 1){
                return redirect()->back()->with("error","Mot de passe eronné, veuillez réessayer.");
            }
            if ($ret == 2){
                return redirect()->back()->with("error","Votre nouveau mot de passe doit être différent du précédent.");
            }
            else {
                return redirect()->back()->with("success","Mot de passe modifié.");
            }
        }

    }

    public function changeInfo(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->get('name');
        $user->save();

        return 1;
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return  1;

        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return 2;
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return 3;

    }
}

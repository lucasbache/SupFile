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

    public function postAuth(Request $request)
    {
        //check which submit was clicked on
        if(Input::get('info')) {
            $ret = $this->changeInfo($request);
            if ($ret == 1){
                return redirect()->back()->with("success","Info changed successfully !");
            }
        } elseif(Input::get('password')) {
            $ret = $this->changePassword($request);
            if ($ret == 1){
                return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            }
            if ($ret == 2){
                return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            }
            else {
                return redirect()->back()->with("success","Password changed successfully !");
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

    public function index()
    {
        $user = Auth::user();
        $stkgUsr = stockage::findSizeByUserId($user->id)->first();

        $stockageUser = round((30000000000 - $stkgUsr->stockageUtilise) / 1000000000);

        $arrondiStockage = round($stockageUser ,0);

        return view('profil', compact('arrondiStockage'));
    }
}

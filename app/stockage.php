<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class stockage extends Model
{
    protected $fillable = ['user_id', 'stockageUtilise'];

    public static function findSizeByUserId($id)
    {
        $sizeById = DB::table('stockages')->where('user_id', '=', $id)->get();
        return $sizeById;
    }

    public static function updateStorage($id, $tailleFic)
    {
        $newSize = DB::table('stockages')
            ->where('user_id', '=', $id)
            ->update(['stockageUtilise' => $tailleFic]);
        return $newSize;
    }
}

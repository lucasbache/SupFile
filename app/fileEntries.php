<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fileEntries extends Model
{
    protected $fillable = ['filepath', 'filename'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $fillable = array(
    	"name"
    	,"category"
    	,"status"
        ,"value"
  	);

    public static function getGeneralStatus(){
        $result = Lookup::select('id','name')->where('status', 'A')->where('category','General Status')->get();
        return $result;
    }
}
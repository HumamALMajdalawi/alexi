<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = array(
    	"icon_name"
        ,"app_name"
    	,"skin"
    	,"owner"
    	,"version"
    	,"per_page"
    	,"per_page_api"
    	,"datetime_format"
  	);
}

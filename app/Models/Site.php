<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //
    protected $fillable = ['name'];
    protected $table = 'sites';

    public function developers()
    {
        return $this->hasMany(Developer::class);
    }

    public function rates(){
    	return $this->hasMany(SiteRates::class);
    }
}

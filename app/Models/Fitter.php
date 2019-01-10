<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fitter extends Model
{
    protected $table = 'fitters';
    protected $fillable = ['name', 'user_id'];

    public function dates()
    {
        return $this->hasMany(FitterDates::class);
    }

    public function job()
    {

    }

    public function fitter_rate(){
    	return $this->hasMany(FitterRates::class);
    }
     
}

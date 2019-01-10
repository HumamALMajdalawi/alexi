<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitterRates extends Model
{
    protected $table = 'fitter_rates';
    protected $fillable = ['type','prices','fitter_id'];
    protected $appends=['fitter_name'];
    protected $casts = [
        'prices' => 'json',
    ];
    public function getPricesAttribute($value)
    {

        $x = json_decode($value,true);
        return json_decode($x);
    }

    public function setPricesAttribute($value)
    {
        $this->attributes['prices'] = json_encode($value);
    }


    public function RateName()
    {
        return $this->hasMany(RateName::class,'rate_name_id');
    }

    public function Fitter()
    {
        return $this->belongsTo(Fitter::class);
    }

    public function getFitterNameAttribute()
    {
        return Fitter::where('id',$this->fitter_id)->first()->name;
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteRates extends Model
{
    //
    protected $fillable = ['site_id','type','prices'];
    protected $appends=["site_name"];

    public function getPricesAttribute($value)
    {

        $x = json_decode($value,true);
        return json_decode($x);
    }

    public function setPricesAttribute($value)
    {
        $this->attributes['prices'] = json_encode($value);
    }

    public function site(){
        return $this->belongsTo(DeveloperSite::class,'site_id','id');
    }

    public function getSiteNameAttribute()
    {
        return DeveloperSite::where('id',$this->site_id)->first()->site_name;
    }
}

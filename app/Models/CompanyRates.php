<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRates extends Model
{
    protected $table = 'company_rates';
    protected $fillable = ['type','prices'];


    public function getPricesAttribute($value)
    {

         $x = json_decode($value,true);
        return json_decode($x);
    }

    public function setPricesAttribute($value)
    {
        $this->attributes['prices'] = json_encode($value);
    }
} 

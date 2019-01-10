<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeveloperSite extends Model
{
    //
    protected $fillable = ['developer_id', 'site_name'];
    protected $table = 'developer_sites';

    public function rates()
    {
        return $this->hasMany(SiteRates::class, 'site_id');
    }

    

}

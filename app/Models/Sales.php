<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'client_order_number',
        'developer',
        'site',
        'plot',
        'house_type',
        'rooms',
        'net_m2',
        'carpet',
        'underlay',
        'matwell',
        'lvt',
        'title_size',
        'stripping',
        'angle',
        'vinyl',
        'wood',
        'value',
        'on_order',
        'screeded_date',
        'screeded_by',
        'fitted_date',
        'fitter',
        'invoice',
        'sign_off',
        'self_billing_date_signed',
        'prep',
        'prep_inv_date',
        'fit',
        'fit_inv_date',
        'protection',
        'protect_inv_date',
        'misc',
        'misc_inv_details',
        'misc_inv_date',
    ];
    protected $table = 'sales';

    public function jobs(){
        return $this->belongsToMany(Job::class);
    }

    public function timeline()
    {
        return $this->hasMany(Timeline::class)->orderBy('created_at','asc');
    }
}

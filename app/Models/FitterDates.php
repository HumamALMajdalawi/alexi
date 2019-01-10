<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitterDates extends Model
{
    protected $table = 'fitter_dates';
    protected $fillable = ['fitter_id', 'date'];

}

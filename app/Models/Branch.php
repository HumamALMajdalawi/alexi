<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'tel',
        'fax',
        'created_by',
    ];
    protected $table = 'branches';

}

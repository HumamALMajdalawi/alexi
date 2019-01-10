<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
  //  protected $fillable = ['name', 'hours', 'email', 'skills'];
      protected $fillable = ['name'];
    //  protected $hidden = ['hours','email', 'skills'];
    protected $table = 'developers';

    public function sites()
    {
        return $this->hasMany(DeveloperSite::class);
    }
}

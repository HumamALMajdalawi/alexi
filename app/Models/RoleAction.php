<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAction extends Model
{
    protected $table = 'role_actions';
    protected $fillable = ['role_id', 'action_id'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title',
        'description',
        'date',
        'assigned_to',
        'due_to',
        'label',
        'creator',
        'is_private',
        'status',
        'price',
        'job_type',
        'notes',
        'sales_id'];
    protected $table = 'jobs';

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator', 'id');
    }

    public function assigned()
    {
        return $this->belongsTo(Fitter::class, 'assigned_to', 'id');
    }

    public function sales()
    {
        return $this->belongsToMany(Sales::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSales extends Model
{
    protected $fillable = [
        'sales_id',
        'job_id',
    ];
    protected $table = 'job_sales';

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}

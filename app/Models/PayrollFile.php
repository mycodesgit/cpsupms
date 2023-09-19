<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollFile extends Model
{
    protected $fillable = [
        'id',
        'payroll_ID',
        'camp_ID',
        'stat_ID',
        'emp_id',
        'emp_pos',
        'sg',
        'salary_rate',
        'total_salary',
        'sal_type',
        'startDate',
        'endDate',
    ];
    // use HasFactory;
}

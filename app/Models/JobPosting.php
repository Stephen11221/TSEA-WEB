<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'location',
        'salary_min',
        'salary_max',
        'job_type',
        'deadline',
        'status',
        'posted_date',
    ];

    /**
     * Get the employer (User) that owns the job posting.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}

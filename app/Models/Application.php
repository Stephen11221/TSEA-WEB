<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id', 'program_id', 'status', 'notes', 
        'submitted_at', 'job_posting_id', 'course_id', 
        'cover_letter', 'resume_path', 'rejection_reason',
        'reviewed_at', 'reviewed_by'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}

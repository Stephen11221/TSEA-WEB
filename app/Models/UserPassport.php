<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPassport extends Model
{
    protected $fillable = [
        'user_id', 'passport_number', 'skills', 
        'experience', 'education', 'certifications', 'status',
        'verified_at', 'verified_by',
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'certifications' => 'array',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
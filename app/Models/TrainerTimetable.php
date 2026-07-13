<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainerTimetable extends Model
{
    protected $fillable = [
        'trainer_id',
        'program_id',
        'title',
        'description',
        'scheduled_for',
        'location',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}

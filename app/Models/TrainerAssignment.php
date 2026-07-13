<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainerAssignment extends Model
{
    protected $fillable = [
        'trainer_id',
        'program_id',
        'title',
        'description',
        'due_at',
        'attachment_path',
    ];

    protected $casts = [
        'due_at' => 'datetime',
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

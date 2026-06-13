<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'company_name', 'logo', 'website', 'industry', 'about', 'address', 'company_size', 'is_verified'])]
class Employer extends Model
{
    /**
     * Get the user that owns the employer profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
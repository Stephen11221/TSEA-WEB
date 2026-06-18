<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
    'title',
    'description',
    'icon',
    'image',
    'status',
    'category',
    'level',
    'scheduled_activation_at',
    'scheduled_deactivation_at',
];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'scheduled_activation_at' => 'datetime',
        'scheduled_deactivation_at' => 'datetime',
    ];
}
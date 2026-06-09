<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasFactory;

    protected $table = 'about_pages';

    protected $fillable = [
        'hero_label',
        'hero_title',
        'hero_description',
        'hero_tagline',

        'mission_title',
        'mission_description',

        'infrastructure_title',
        'infrastructure_description',

        'impact_title',
        'impact_description',

        'hero_image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
}
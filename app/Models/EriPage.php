<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EriPage extends Model
{
    protected $fillable = [
        'hero_eyebrow',
        'hero_title',
        'hero_description',
        'eri_score',
        'score_label',
        'score_message',
        'competencies',
        'recommendations',
    ];

    protected $casts = [
        'competencies' => 'array',
        'recommendations' => 'array',
    ];
}
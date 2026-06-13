<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkforcePassport extends Model
{
    protected $fillable = [
        'hero_label',
        'hero_title',
        'hero_description',
        'cta_text',

        'profile_name',
        'profile_location',
        'passport_score',

        'skill_name_1',
        'skill_score_1',
        'skill_name_2',
        'skill_score_2',
        'skill_name_3',
        'skill_score_3',
        'skill_name_4',
        'skill_score_4',
        'skill_name_5',
        'skill_score_5',

        'credential_1',
        'credential_2',
        'credential_3',
        'credential_4',

        'readiness_1',
        'readiness_2',
        'readiness_3',

        'benefit_1',
        'benefit_2',
        'benefit_3',
        'benefit_4',
        'benefit_5',
        'benefit_6',
    ];
}
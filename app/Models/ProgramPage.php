<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPage extends Model
{
    protected $fillable = [
        'hero_label',
        'hero_title',
        'hero_description',
    ];
}
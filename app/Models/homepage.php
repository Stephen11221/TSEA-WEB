<?php

// app/Models/HomepageSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    protected $fillable = [
        'hero_eyebrow',
        'hero_title',
        'hero_description',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
    ];
}
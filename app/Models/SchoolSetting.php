<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'logo',
        'address',
        'city',
        'state',
        'pincode',
        'phone',
        'email',
        'website',
        'youtube_link',
        'facebook_link',
        'instagram_link',
        'description',
    ];
}

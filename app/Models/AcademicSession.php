<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'is_current'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function studentSessions()
    {
        return $this->hasMany(StudentSession::class);
    }

    public static function current()
    {
        return self::where('is_current', true)->first();
    }
}

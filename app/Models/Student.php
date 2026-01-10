<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'dob',
        'class_id',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function studentSessions()
    {
        return $this->hasMany(StudentSession::class);
    }

    public function scopeActive($query)
    {
        // Assuming all students are active for now, or you can add an is_active column
        return $query;
    }
}

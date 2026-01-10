<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'fee_head',
        'amount',
        'fee_type',
        'frequency',
        'is_mandatory',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_mandatory' => 'boolean',
    ];

    // Relationship with Class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}

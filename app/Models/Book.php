<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'quantity',
        'available_quantity',
        'rack_number',
    ];

    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }
}

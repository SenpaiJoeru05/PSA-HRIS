<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $fillable = [
        'name',
    ];

    // Relationships
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    // Add other relationships as needed

    // Example of other methods or scopes
    // For example, if you want to get active divisions:
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Headquarter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active'
    ];

    /**
     * Relationships
     */

    /**
     * Headquarter has many Branches
     */

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}

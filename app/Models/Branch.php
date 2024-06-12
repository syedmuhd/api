<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    const TABLE_RELATIONSHIP_USER_BRANCH = 'user_branch';

    protected $fillable = [
        'headquarter_id',
        'name',
        'is_active'
    ];

    /**
     * Relationships
     */

    /**
     * Branch belongs to a Headquarter
     */
    public function headquarter(): BelongsTo
    {
        return $this->belongsTo(Headquarter::class);
    }

    /**
     * Has many Roles
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    /**
     * Has many Users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, self::TABLE_RELATIONSHIP_USER_BRANCH);
    }
}

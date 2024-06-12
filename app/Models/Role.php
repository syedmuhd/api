<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    const ROLE_SUPER_ADMINISTRATOR = "Super Administrator";
    const ROLE_ADMINISTRATOR = "Administrator";
    const ROLE_STAFF = "Staff";
    const ROLE_PARENT = "Parent";
    const ROLE_STUDENT = "Student";
    const TABLE_RELATIONSHIP_ROLE_PERMISSION = 'role_permission';

    protected $fillable = [
        'name'
    ];

    /**
     * Functions
     */
    public static function getDefaultRoles()
    {
        return [
            self::ROLE_ADMINISTRATOR,
            self::ROLE_STAFF,
            self::ROLE_PARENT,
            self::ROLE_STUDENT
        ];
    }

    /**
     * Relationships
     */

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, self::TABLE_RELATIONSHIP_ROLE_PERMISSION);
    }

    /**
     * 
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }
}

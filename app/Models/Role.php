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

    const TABLE_RELATIONSHIP_USER_ROLE = 'user_role';
    const TABLE_RELATIONSHIP_ROLE_PERMISSION = 'role_permission';

    protected $fillable = [
        'name'
    ];

    /**
     * Functions
     */
    public static function getDefaultRoles()
    {
        return Role::find([2, 3, 4, 5]);
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
        return $this->belongsToMany(User::class, self::TABLE_RELATIONSHIP_USER_ROLE);
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Listeners\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use function Illuminate\Events\queueable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    const TABLE_RELATIONSHIP_USER_ROLE = 'user_role';
    const TABLE_RELATIONSHIP_USER_PERMISSIONS = 'user_permission';
    const TABLE_RELATIONSHIP_USER_BRANCH = 'user_branch';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'phone',
        'email',
        'password',
        'last_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Functions
     */
    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }

    public function isSuperAdministrator(): bool
    {
        return in_array(Role::ROLE_SUPER_ADMINISTRATOR, $this->roles->pluck('name')->toArray());
    }

    /**
     * Events
     */
    protected static function booted(): void
    {
        static::created(queueable(function (User $user) {
            // Create user profile
            $user->profile()->save(new Profile());
        }));
    }

    /**
     * Relationships
     */

    // Profile
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * If user role is [Admin, Staff, Parent, Student]
     * User belongs to a Branch
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, self::TABLE_RELATIONSHIP_USER_BRANCH);
    }

    /**
     * If user role is Parent
     * Parent can have many students
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_student', 'parent_id', 'student_id', 'id', 'id');
    }

    /**
     * Has Many Roles
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Has Many Permissions
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, self::TABLE_RELATIONSHIP_USER_PERMISSIONS);
    }
}

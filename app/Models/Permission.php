<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Permission extends Model
{
    use HasFactory;

    const TABLE_RELATIONSHIP_ROLE_PERMISSION = 'role_permission';
    const TABLE_RELATIONSHIP_BRANCH_PERMISSION = 'branch_permission';

    protected $fillable = [
        'name'
    ];

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class);
    }
}

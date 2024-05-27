<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory;

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
}

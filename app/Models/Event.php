<?php

namespace App\Models;

use App\Models\Traits\FilterableTrait;
use App\Models\Traits\UnguardedAttributesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 */
class Event extends Model
{
    use HasFactory;
    use UnguardedAttributesTrait;
    use FilterableTrait;

    /**
     * Schedule relation.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(EventSchedule::class, 'event_id');
    }
}

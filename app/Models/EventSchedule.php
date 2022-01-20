<?php

namespace App\Models;

use App\Models\Traits\FilterableTrait;
use App\Models\Traits\UnguardedAttributesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $event_id
 * @property \Carbon\Carbon $date
 */
class EventSchedule extends Model
{
    use HasFactory;
    use UnguardedAttributesTrait;
    use FilterableTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    /**
     * Event Relation.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}

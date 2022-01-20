<?php

namespace App\Filters;

use Carbon\Carbon;

class EventScheduleFilter extends AbstractFilter
{
    /**
     * Filter by date - start_at
     */
    public function startAt(string $value): void
    {
        $value = Carbon::parse($value);

        $this->builder->where('date', '>=', $value);
    }

    /**
     * Filter by date - end_at
     */
    public function endAt(string $value): void
    {
        $value = Carbon::parse($value);

        $this->builder->where('date', '<=', $value);
    }
}
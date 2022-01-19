<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EventService extends AbstractService
{
    public function store(array $data): array
    {
        $event = $this->model->firstOrCreate([
            'name' => data_get($data, 'name')
        ]);

        $dates = $this->getDaysOfRange(
            data_get($data, 'start_at'),
            data_get($data, 'end_at'),
            data_get($data, 'days')
        );

        // dd($dates);

        // Delete Schedules
        $event->schedules()->delete();

        // Create Schedules
        $test = $event->schedules()->createMany($dates);

        return $event->toArray();
    }

    
    /**
     * Get Days of Range
     */
    public function getDaysOfRange(string $startAt, string $endAt, array $days): array
    {
        $startAt = Carbon::parse($startAt);
        $endAt = Carbon::parse($endAt);

        $dates = CarbonPeriod::create(
                $startAt,
                $endAt
            )
            ->addFilter(function (Carbon $date) use ($days) {
                return in_array($date->dayOfWeek, $days);
            })
            ->toArray();

        return collect($dates)->map(fn (Carbon $date) => ['date' => $date->toDateString()])
                ->toArray();
    }
}
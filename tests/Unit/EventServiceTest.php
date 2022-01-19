<?php

namespace Tests\Unit;

use App\Enums\CarbonDays;
use App\Services\EventService;
use Carbon\Carbon;
use Tests\TestCase as TestCase;

class EventServiceTest extends TestCase
{
    protected $service;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(EventService::class);
    }
    
    public function test_get_days_from_range()
    {
        $this->assertNotNull($this->service->getDaysOfRange(now(), now()->addMonth(), [0]));
    }

    /**
     * @dataProvider dates
     */
    public function test_get_days_from_range_filter_by_day_should_get_specific_day_only($day)
    {
        $dates = $this->service->getDaysOfRange(now(), now()->addMonth(), [$day]);

        collect($dates)->flatten()->each(function ($date) use ($day){
            $this->assertTrue(in_array(Carbon::parse($date)->dayOfWeek, [$day]));
        });
    }

    public function dates()
    {
        return collect(CarbonDays::all())->map(function ($day) {
            return ['day' => $day];
        });
    }
}

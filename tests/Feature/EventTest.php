<?php

namespace Tests\Unit;

use App\Enums\CarbonDays;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EventTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider filters
     * 
     * @param string $field
     */
    public function test_filter_by_field($field)
    {
        $event = Event::factory()->hasSchedules(10)->create();
        
        $schedule = $event->schedules()->orderBy('date')->pluck('date')->first()->format('Y-m-d');

        $this->get("/api/calendar?filter[{$field}]={$schedule}")
            ->assertSuccessful()
            ->assertJsonFragment([
                'date' => $schedule
            ]);
    }

    public function test_filter_by_date_range()
    {
        $event = Event::factory()->hasSchedules(10)->create();
        
        $oldest = $event->schedules()->orderBy('date')->pluck('date')->first()->format('Y-m-d');
        $latest = $event->schedules()->orderBy('date')->pluck('date')->last()->format('Y-m-d');

        $this->get("/api/calendar?filter[start_at]={$oldest}&filter[end_at]={$latest}")
            ->assertSuccessful()
            ->assertJsonCount(10);
    }

    public function test_create_event()
    {
        $data = [
            'name' => 'Testing',
            'start_at' => now()->toDateString(),
            'end_at' => now()->addMonth()->toDateString(),
            'days' => [
                CarbonDays::MONDAY
            ]
        ];

        $this->post('/api/calendar', $data)
            ->assertSuccessful();
    }

    /**
     * @dataProvider dates
     */
    public function test_create_event_should_only_have_specific_day_schedules($day)
    {
        $data = [
            'name' => 'Testing',
            'start_at' => now()->toDateString(),
            'end_at' => now()->addMonth()->toDateString(),
            'days' => [
                $day
            ]
        ];

        $this->post('/api/calendar', $data)
            ->assertSuccessful();

        $responseData = $this->get('/api/calendar')
                            ->assertSuccessful()
                            ->decodeResponseJson()
                            ->json();

        collect($responseData)->each(function ($schedule) use ($day) {
            $this->assertTrue(Carbon::parse(
                data_get($schedule, 'date')
            )->dayOfWeek == $day);
        });
    }

    public function test_create_event_with_existing_name_should_update_schedules()
    {
        $event = Event::factory()->create();

        $data = [
            'name' => $event->name,
            'start_at' => now()->toDateString(),
            'end_at' => now()->addMonth()->toDateString(),
            'days' => CarbonDays::all()
        ];

        $this->post('/api/calendar', $data)
            ->assertSuccessful();

        $this->get('/api/calendar')
            ->assertJsonFragment([
                'date' => now()->toDateString()
            ]);
    }

    public function filters()
    {
        return [
            'Start At' => [
                'start_at'
            ],
            'End At' => [
                'end_at'
            ],
        ];
    }

    public function dates()
    {
        return collect(CarbonDays::all())->map(function ($day) {
            return ['day' => $day];
        });
    }
}

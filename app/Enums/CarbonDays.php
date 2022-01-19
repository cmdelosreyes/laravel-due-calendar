<?php

namespace App\Enums;

use Carbon\Carbon;

class CarbonDays extends AbstractEnum
{
    public const SUNDAY = Carbon::SUNDAY;
    public const MONDAY = Carbon::MONDAY;
    public const TUESDAY = Carbon::TUESDAY;
    public const WEDNESDAY = Carbon::WEDNESDAY;
    public const THURSDAY = Carbon::THURSDAY;
    public const FRIDAY = Carbon::FRIDAY;
    public const SATURDAY = Carbon::SATURDAY;
}
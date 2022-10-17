<?php

namespace App\Utils\Trend;

class TrendValue
{
    public function __construct(
        public string $date,
        public mixed  $aggregate,
    )
    {
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'event_name',
        'organizer',
        'event_date',
        'expected_attendees',
        'status',
        'current_count',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'expected_attendees' => 'integer',
            'current_count' => 'integer',
        ];
    }

    /**
     * Get the monitoring level, Bootstrap color, and current capacity percentage.
     *
     * @return array{level: string, color: string, percent: float}
     */
    public function dangerLevel(): array
    {
        $capacity = (int) config('amphitheater.capacity');
        $percent = $capacity > 0 ? ($this->current_count / $capacity) * 100 : 0;
        $thresholds = config('amphitheater.thresholds');

        [$level, $color] = match (true) {
            $percent < $thresholds['safe'] => ['Safe', 'success'],
            $percent < $thresholds['moderate'] => ['Moderate', 'info'],
            $percent < $thresholds['high'] => ['High', 'warning'],
            $percent <= $thresholds['critical'] => ['Critical', 'danger'],
            default => ['Over capacity', 'dark'],
        };

        return [
            'level' => $level,
            'color' => $color,
            'percent' => round($percent, 2),
        ];
    }
}

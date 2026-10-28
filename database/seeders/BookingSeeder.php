<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'event_name' => 'Anahaw Cultural Festival',
                'organizer' => 'City Culture and Arts Office',
                'event_date' => today()->addDays(30),
                'expected_attendees' => 5000,
                'status' => 'upcoming',
            ],
            [
                'event_name' => 'Community Sports Day',
                'organizer' => 'City Sports Development Office',
                'event_date' => today(),
                'expected_attendees' => 6000,
                'status' => 'ongoing',
                'current_count' => 4200,
            ],
            [
                'event_name' => 'Public Service Expo',
                'organizer' => 'City Government',
                'event_date' => today()->addDays(14),
                'expected_attendees' => 3500,
                'status' => 'upcoming',
            ],
            [
                'event_name' => 'Barangay Music Night',
                'organizer' => 'Office of Community Affairs',
                'event_date' => today()->subDays(7),
                'expected_attendees' => 2500,
                'status' => 'completed',
                'current_count' => 2100,
            ],
        ] as $booking) {
            Booking::updateOrCreate(
                ['event_name' => $booking['event_name']],
                $booking,
            );
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BookingSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_the_ongoing_event_and_its_capacity_level(): void
    {
        Booking::create([
            'event_name' => 'Community Gathering',
            'organizer' => 'City Government',
            'event_date' => today(),
            'expected_attendees' => 6000,
            'status' => 'ongoing',
            'current_count' => 6000,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Community Gathering')
            ->assertSee('6,000')
            ->assertSee('High')
            ->assertSee('85.71%');
    }

    #[DataProvider('capacityLevels')]
    public function test_danger_level_matches_capacity_thresholds(int $count, string $level, float $percent): void
    {
        $booking = new Booking(['current_count' => $count]);
        $danger = $booking->dangerLevel();

        $this->assertSame($level, $danger['level']);
        $this->assertSame($percent, $danger['percent']);
    }

    public static function capacityLevels(): array
    {
        return [
            'below safe threshold' => [4199, 'Safe', 59.99],
            'at moderate threshold' => [4200, 'Moderate', 60.0],
            'below high threshold' => [5599, 'Moderate', 79.99],
            'at high threshold' => [5600, 'High', 80.0],
            'below critical threshold' => [6649, 'High', 94.99],
            'at critical threshold' => [6650, 'Critical', 95.0],
            'at capacity' => [7000, 'Critical', 100.0],
            'over capacity' => [7001, 'Over capacity', 100.01],
        ];
    }

    public function test_dashboard_count_can_be_set_and_adjusted_without_going_below_zero(): void
    {
        $booking = Booking::create([
            'event_name' => 'Community Gathering',
            'organizer' => 'City Government',
            'event_date' => today(),
            'expected_attendees' => 1000,
            'status' => 'ongoing',
            'current_count' => 5,
        ]);

        $this->post(route('dashboard.count'), ['current_count' => 25])
            ->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'current_count' => 25]);

        $this->post(route('dashboard.count'), ['adjustment' => -10])
            ->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'current_count' => 15]);

        $this->post(route('dashboard.count'), ['adjustment' => -10])
            ->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'current_count' => 5]);

        $this->post(route('dashboard.count'), ['adjustment' => -10])
            ->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'current_count' => 0]);
    }

    public function test_booking_creation_rejects_expected_attendance_above_capacity(): void
    {
        $this->from(route('bookings.create'))
            ->post(route('bookings.store'), [
                'event_name' => 'Oversized Event',
                'organizer' => 'City Government',
                'event_date' => today()->toDateString(),
                'expected_attendees' => 7001,
                'status' => 'upcoming',
                'current_count' => 0,
            ])
            ->assertRedirect(route('bookings.create'))
            ->assertSessionHasErrors('expected_attendees');

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_dashboard_reports_when_there_is_no_ongoing_event(): void
    {
        $this->get('/')->assertOk()->assertSee('There is no ongoing event.');
    }
}

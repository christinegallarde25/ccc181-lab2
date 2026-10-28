<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'ongoingBooking' => Booking::query()
                ->where('status', 'ongoing')
                ->orderBy('event_date')
                ->orderBy('id')
                ->first(),
            'upcomingBookings' => Booking::query()
                ->where('status', 'upcoming')
                ->whereDate('event_date', '>=', today())
                ->orderBy('event_date')
                ->limit(5)
                ->get(),
            'capacity' => config('amphitheater.capacity'),
        ]);
    }

    public function updateCount(Request $request): RedirectResponse
    {
        $booking = Booking::query()->where('status', 'ongoing')->orderBy('event_date')->orderBy('id')->first();

        if (! $booking) {
            return to_route('dashboard')->with('error', 'There is no ongoing event to update.');
        }

        if ($request->has('adjustment')) {
            $validated = $request->validate([
                'adjustment' => ['required', 'integer', 'in:-10,10'],
            ]);

            $booking->current_count = max(0, $booking->current_count + $validated['adjustment']);
        } else {
            $validated = $request->validate([
                'current_count' => ['required', 'integer', 'min:0'],
            ]);

            $booking->current_count = $validated['current_count'];
        }

        $booking->save();

        return to_route('dashboard')->with('success', 'Attendee count updated successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('bookings.index', [
            'bookings' => Booking::query()->orderByDesc('event_date')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('bookings.create', ['booking' => new Booking]);
    }

    public function store(Request $request): RedirectResponse
    {
        Booking::create($this->validatedBooking($request));

        return to_route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking): View
    {
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $booking->update($this->validatedBooking($request));

        return to_route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return to_route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedBooking(Request $request): array
    {
        return $request->validate([
            'event_name' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'expected_attendees' => [
                'required',
                'integer',
                'min:1',
                'max:'.config('amphitheater.capacity'),
            ],
            'status' => ['required', 'in:upcoming,ongoing,completed'],
            'current_count' => ['required', 'integer', 'min:0'],
        ], [
            'expected_attendees.max' => 'Expected attendees cannot exceed the amphitheatre capacity of :max.',
        ]);
    }
}

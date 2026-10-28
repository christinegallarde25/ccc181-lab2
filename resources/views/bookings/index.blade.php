@extends('layouts.app')

@section('title', 'Bookings')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Bookings</h1>
            <p class="text-secondary mb-0">Manage events at Anahaw Amphitheatre.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('bookings.create') }}">New Booking</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">Organizer</th>
                        <th scope="col">Date</th>
                        <th scope="col">Expected</th>
                        <th scope="col">Status</th>
                        <th scope="col">Current count</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="fw-semibold">{{ $booking->event_name }}</td>
                            <td>{{ $booking->organizer }}</td>
                            <td>{{ $booking->event_date->format('M j, Y') }}</td>
                            <td>{{ number_format($booking->expected_attendees) }}</td>
                            <td><span class="badge text-bg-{{ $booking->status === 'ongoing' ? 'success' : ($booking->status === 'completed' ? 'secondary' : 'primary') }}">{{ ucfirst($booking->status) }}</span></td>
                            <td>{{ number_format($booking->current_count) }}</td>
                            <td class="text-end text-nowrap">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('bookings.edit', $booking) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('bookings.destroy', $booking) }}" onsubmit="return confirm('Delete this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="text-center text-secondary py-4" colspan="7">No bookings yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $bookings->links() }}</div>
@endsection

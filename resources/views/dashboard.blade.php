@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Event monitoring</h1>
            <p class="text-secondary mb-0">Anahaw Amphitheatre capacity: {{ number_format($capacity) }}</p>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('bookings.index') }}">Manage bookings</a>
    </div>

    @if ($ongoingBooking)
        @php($danger = $ongoingBooking->dangerLevel())
        <section class="card shadow-sm mb-4" aria-labelledby="ongoing-event-heading">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                    <div>
                        <p class="text-uppercase text-secondary small fw-semibold mb-1">Ongoing event</p>
                        <h2 class="h3 mb-1" id="ongoing-event-heading">{{ $ongoingBooking->event_name }}</h2>
                        <p class="text-secondary mb-0">{{ $ongoingBooking->organizer }} &middot; {{ $ongoingBooking->event_date->format('M j, Y') }}</p>
                    </div>
                    <span class="badge align-self-start fs-6 text-bg-{{ $danger['color'] }}">{{ $danger['level'] }}</span>
                </div>

                <div class="row align-items-end g-3 mb-2">
                    <div class="col">
                        <div class="display-3 fw-bold lh-1">{{ number_format($ongoingBooking->current_count) }}</div>
                        <div class="text-secondary mt-2">attendees currently counted</div>
                    </div>
                    <div class="col-auto text-end">
                        <div class="h5 mb-1">{{ number_format($ongoingBooking->expected_attendees) }} expected</div>
                        <div class="text-secondary">of {{ number_format($capacity) }} capacity</div>
                    </div>
                </div>
                <div class="progress mb-4" role="progressbar" aria-label="Capacity used" aria-valuenow="{{ min(100, $danger['percent']) }}" aria-valuemin="0" aria-valuemax="100" style="height: 1.25rem">
                    <div class="progress-bar bg-{{ $danger['color'] }}" style="width: {{ min(100, $danger['percent']) }}%">
                        {{ number_format($danger['percent'], 2) }}%
                    </div>
                </div>

                <form method="POST" action="{{ route('dashboard.count') }}" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-sm-5 col-md-4">
                        <label for="current_count" class="form-label">Set current attendee count</label>
                        <input class="form-control" type="number" name="current_count" id="current_count" min="0" step="1" value="{{ old('current_count', $ongoingBooking->current_count) }}" required>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-secondary" type="submit" name="adjustment" value="-10" aria-label="Subtract 10 attendees">-10</button>
                        <button class="btn btn-outline-secondary" type="submit" name="adjustment" value="10" aria-label="Add 10 attendees">+10</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">Update count</button>
                    </div>
                </form>
            </div>
        </section>
    @else
        <div class="alert alert-info mb-4" role="status">There is no ongoing event.</div>
    @endif

    @if ($upcomingBookings->isNotEmpty())
        <section class="card shadow-sm">
            <div class="card-header bg-white"><h2 class="h5 mb-0">Upcoming bookings</h2></div>
            <ul class="list-group list-group-flush">
                @foreach ($upcomingBookings as $booking)
                    <li class="list-group-item d-flex justify-content-between flex-wrap gap-2">
                        <div>
                            <strong>{{ $booking->event_name }}</strong>
                            <span class="text-secondary">&middot; {{ $booking->organizer }}</span>
                        </div>
                        <span>{{ $booking->event_date->format('M j, Y') }} &middot; {{ number_format($booking->expected_attendees) }} expected</span>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection

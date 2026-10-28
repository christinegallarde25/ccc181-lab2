<div class="row g-3">
    <div class="col-md-6">
        <label for="event_name" class="form-label">Event name</label>
        <input class="form-control @error('event_name') is-invalid @enderror" type="text" name="event_name" id="event_name" value="{{ old('event_name', $booking->event_name) }}" maxlength="255" required>
        @error('event_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label for="organizer" class="form-label">Organizer / LGU department</label>
        <input class="form-control @error('organizer') is-invalid @enderror" type="text" name="organizer" id="organizer" value="{{ old('organizer', $booking->organizer) }}" maxlength="255" required>
        @error('organizer') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label for="event_date" class="form-label">Event date</label>
        <input class="form-control @error('event_date') is-invalid @enderror" type="date" name="event_date" id="event_date" value="{{ old('event_date', $booking->event_date?->format('Y-m-d')) }}" required>
        @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label for="expected_attendees" class="form-label">Expected attendees</label>
        <input class="form-control @error('expected_attendees') is-invalid @enderror" type="number" name="expected_attendees" id="expected_attendees" value="{{ old('expected_attendees', $booking->expected_attendees) }}" min="1" max="{{ config('amphitheater.capacity') }}" required>
        @error('expected_attendees') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
            @foreach (['upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $booking->status ?? 'upcoming') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label for="current_count" class="form-label">Current attendee count</label>
        <input class="form-control @error('current_count') is-invalid @enderror" type="number" name="current_count" id="current_count" value="{{ old('current_count', $booking->current_count ?? 0) }}" min="0" required>
        @error('current_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary" type="submit">{{ $submitLabel }}</button>
    <a class="btn btn-outline-secondary" href="{{ route('bookings.index') }}">Cancel</a>
</div>

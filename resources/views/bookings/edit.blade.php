@extends('layouts.main')

@section('title', 'Edit Booking')

@section('content')
    <div class="mb-4">
        <h1 class="h2 mb-1">Edit Booking</h1>
        <p class="text-secondary mb-0">Update {{ $booking->event_name }}.</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('bookings.update', $booking) }}">
                @csrf
                @method('PUT')
                @include('bookings._form', ['submitLabel' => 'Save changes'])
            </form>
        </div>
    </div>
@endsection

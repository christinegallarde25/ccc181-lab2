@extends('layouts.main')

@section('title', 'New Booking')

@section('content')
    <div class="mb-4">
        <h1 class="h2 mb-1">New Booking</h1>
        <p class="text-secondary mb-0">Add an event at Anahaw Amphitheatre.</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf
                @include('bookings._form', ['submitLabel' => 'Create booking'])
            </form>
        </div>
    </div>
@endsection

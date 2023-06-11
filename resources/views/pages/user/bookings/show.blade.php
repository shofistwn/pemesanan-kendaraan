@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <h1 class="text-center">Detail Booking</h1>

                <div class="card mt-4">
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Driver</label>
                                <input type="text" class="form-control" value="{{ $booking->driver->driver_name }}"
                                    disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vehicle Type</label>
                                <input type="text" class="form-control" value="{{ $booking->vehicle->vehicle_type }}"
                                    disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vehicle Number</label>
                                <input type="text" class="form-control" value="{{ $booking->vehicle->vehicle_type }}"
                                    disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Approver</label>
                                <input type="text" class="form-control"
                                    value="{{ $booking->approval->get(0)->user->name ?? '-' }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Second Approver</label>
                                <input type="text" class="form-control"
                                    value="{{ $booking->approval->get(1)->user->name ?? '-' }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                @if ($booking->approval->get(0)->approval_status == 'pending')
                                    <input type="text" class="form-control" value="Pending Approver 1" disabled>
                                @elseif ($booking->approval->get(0)->approval_status == 'approved')
                                    <input type="text" class="form-control" value="Pending Approver 2" disabled>
                                @elseif ($booking->approval->get(1)->approval_status == 'approved')
                                    <input type="text" class="form-control" value="Approved" disabled>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" value="{{ $booking->booking_date }}" disabled>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('user.bookings.index') }}" class="btn btn-secondary me-2">Back</a>
                                <a href="{{ route('user.bookings.edit', $booking->id) }}" class="btn btn-primary">Edit</a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

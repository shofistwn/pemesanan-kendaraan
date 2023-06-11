@extends('layouts.admin')

@section('title', 'Edit Booking')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <h1 class="text-center">Edit Booking</h1>

                <div class="card mt-4">
                    <div class="card-body">

                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ Session::get('error') }}
                                @php
                                    Session::forget('error');
                                @endphp
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Driver</label>
                                <select class="form-select" name="driver_id">
                                    <option selected disabled>Select:</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}" @selected($driver->id === $booking->driver_id)>
                                            {{ $driver->driver_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vehicle Number</label>
                                <select class="form-select" name="vehicle_id">
                                    <option selected disabled>Select:</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" @selected($vehicle->id === $booking->vehicle_id)>
                                            {{ $vehicle->vehicle_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Approver</label>
                                <select class="form-select" name="first_approver_id">
                                    <option selected disabled>Select:</option>
                                    @foreach ($firstApprovers as $firstApprover)
                                        <option value="{{ $firstApprover->id }}" @selected($firstApprover->id === $booking->approval->get(0)->user_id)>
                                            {{ $firstApprover->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Second Approver</label>
                                <select class="form-select" name="second_approver_id">
                                    <option selected disabled>Select:</option>
                                    @foreach ($secondApprovers as $secondApprover)
                                        <option value="{{ $secondApprover->id }}" @selected($secondApprover->id === $booking->approval->get(1)->user_id)>
                                            {{ $secondApprover->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary me-2">Back</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

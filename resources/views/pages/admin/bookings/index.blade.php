@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')

    <div class="container">

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                @php
                    Session::forget('error');
                @endphp
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h1>Bookings</h1>
            <div>
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary me-2">Add Booking</a>
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-success">Export Excel</a>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.bookings.search') }}">
                    <div class="row">
                        <div class="form-group col-md-4 mb-3">
                            <label for="startDate">Start date:</label>
                            <input type="date" class="form-control" id="startDate" name="start_date">
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="endDate">End date:</label>
                            <input type="date" class="form-control" id="endDate" name="end_date">
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="type">Type:</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">Select:</option>
                                <option value="passenger">Passenger Vehicle</option>
                                <option value="cargo">Cargo Vehicle</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary w-100">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped m-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Driver</th>
                                <th>Vehicle Type</th>
                                <th>Vehicle Number</th>
                                <th>First Approver</th>
                                <th>Second Approver</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $index => $booking)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $booking->driver->driver_name }}</td>
                                    <td>{{ $booking->vehicle->vehicle_type }}</td>
                                    <td>{{ $booking->vehicle->vehicle_number }}</td>
                                    <td>{{ $booking->approval->get(0)->user->name ?? '-' }}</td>
                                    <td>{{ $booking->approval->get(1)->user->name ?? '-' }}</td>
                                    <th>
                                        @if ($booking->approval->isEmpty())
                                            -
                                        @elseif (
                                            $booking->approval->get(0)->approval_status == 'rejected' ||
                                                $booking->approval->get(1)->approval_status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @elseif ($booking->approval->get(0)->approval_status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending Approver 1</span>
                                        @elseif ($booking->approval->get(1)->approval_status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif ($booking->approval->get(0)->approval_status == 'approved')
                                            <span class="badge bg-warning text-dark">Pending Approver 2</span>
                                        @endif
                                    </th>
                                    <td>{{ $booking->booking_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                            class="badge bg-primary text-decoration-none text-white">Detail</a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                            class="badge bg-success text-decoration-none text-white">Edit</a>
                                        <a href="{{ route('admin.bookings.delete', $booking->id) }}"
                                            class="badge bg-danger text-decoration-none text-white"
                                            onclick="return confirm('Are you sure you want to delete the data?')">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data not found!</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

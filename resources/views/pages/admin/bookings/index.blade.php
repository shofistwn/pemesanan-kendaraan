@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Bookings</h1>
            <div>
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary me-2">Add Booking</a>
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-success">Export Excel</a>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="startDate">Start date:</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="endDate">End date:</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status">
                                <option value="">Select</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="type">Type:</label>
                            <select class="form-control" id="type">
                                <option value="">Select</option>
                                <option value="passenger">Passenger Vehicles</option>
                                <option value="cargo">Cargo Vehicles</option>
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
                            <tr>
                                <td>1</td>
                                <td>Jonathan</td>
                                <td>Angkutan Orang</td>
                                <td>AG 8689 YG</td>
                                <td>Level 1</td>
                                <td>Level 2</td>
                                <th>
                                    <span class="badge bg-primary">Pending Approver 2</span>
                                </th>
                                <td>20 Jun, 2022</td>
                                <td>
                                    <a href="{{ route('admin.bookings.show') }}"
                                        class="badge bg-primary text-decoration-none text-white">Detail</a>
                                    <a href="{{ route('admin.bookings.edit') }}"
                                        class="badge bg-success text-decoration-none text-white">Edit</a>
                                    <a href="" class="badge bg-danger text-decoration-none text-white"
                                        onclick="return confirm('Are you sure you want to delete the data?')">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

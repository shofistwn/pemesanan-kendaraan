@extends('layouts.admin')

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
                                <input type="text" class="form-control" value="Jonathan" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vehicle Type</label>
                                <input type="text" class="form-control" value="Angkutan Orang" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vehicle Number</label>
                                <input type="text" class="form-control" value="AG HGUJ JG" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Approver</label>
                                <input type="text" class="form-control" value="Jane" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Second Approver</label>
                                <input type="text" class="form-control" value="Andre" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="Accepted" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" value="20 Jan, 2022" disabled>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary me-2">Back</a>
                                <a href="{{ route('admin.bookings.edit') }}" class="btn btn-primary">Edit</a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

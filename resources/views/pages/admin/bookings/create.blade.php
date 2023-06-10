@extends('layouts.admin')

@section('title', 'Add Booking')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <h1 class="text-center">Add Booking</h1>

                <div class="card mt-4">
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Driver</label>
                                <select class="form-select">
                                    <option selected disabled>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vehicle</label>
                                <select class="form-select">
                                    <option selected disabled>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Approver</label>
                                <select class="form-select">
                                    <option selected disabled>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Second Approver</label>
                                <select class="form-select">
                                    <option selected disabled>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
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

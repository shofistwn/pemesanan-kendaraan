@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Dashboard</h1>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-8 col-lg-9 h4 card-title m-0">
                        Vehicle Type
                    </div>
                    <div class="col mt-3 mt-lg-0">
                        <select class="form-select form-select-sm select-type">
                            <option value="1" selected>All</option>
                            <option value="2">Passenger Vehicles</option>
                            <option value="3">Cargo Vehicles</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-area">
                    <canvas id="typeChart1"></canvas>
                </div>
                <div class="chart-area">
                    <canvas id="typeChart2"></canvas>
                </div>
                <div class="chart-area">
                    <canvas id="typeChart3"></canvas>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-8 col-lg-9 h4 card-title m-0">
                      Booking Status
                    </div>
                    <div class="col mt-3 mt-lg-0">
                        <select class="form-select form-select-sm select-status">
                            <option value="1" selected>All</option>
                            <option value="2">Approved</option>
                            <option value="3">Rejected</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body pt-4">
                <div class="chart-area">
                    <canvas id="statusChart1"></canvas>
                </div>
                <div class="chart-area">
                    <canvas id="statusChart2"></canvas>
                </div>
                <div class="chart-area">
                    <canvas id="statusChart3"></canvas>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Bookings</h4>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">See All</a>
            </div>
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
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/type-chart.js') }}"></script>
    <script src="{{ asset('assets/js/status-chart.js') }}"></script>

    <script>
        var dropdown1 = document.querySelector(".select-type");
        var typeChart1 = document.getElementById("typeChart1");
        var typeChart2 = document.getElementById("typeChart2");
        var typeChart3 = document.getElementById("typeChart3");

        typeChart1.style.display = "block";
        typeChart2.style.display = "none";
        typeChart3.style.display = "none";

        dropdown1.addEventListener("change", function() {
            var selectedValue = dropdown1.value;

            if (selectedValue === "1") {
                typeChart1.style.display = "block";
                typeChart2.style.display = "none";
                typeChart3.style.display = "none";
            } else if (selectedValue === "2") {
                typeChart1.style.display = "none";
                typeChart2.style.display = "block";
                typeChart3.style.display = "none";
            } else if (selectedValue === "3") {
                typeChart1.style.display = "none";
                typeChart2.style.display = "none";
                typeChart3.style.display = "block";
            }
        });

        var dropdown2 = document.querySelector(".select-status");
        var statusChart1 = document.getElementById("statusChart1");
        var statusChart2 = document.getElementById("statusChart2");
        var statusChart3 = document.getElementById("statusChart3");

        statusChart1.style.display = "block";
        statusChart2.style.display = "none";
        statusChart3.style.display = "none";

        dropdown2.addEventListener("change", function() {
            var selectedValue = dropdown2.value;

            if (selectedValue === "1") {
                statusChart1.style.display = "block";
                statusChart2.style.display = "none";
                statusChart3.style.display = "none";
            } else if (selectedValue === "2") {
                statusChart1.style.display = "none";
                statusChart2.style.display = "block";
                statusChart3.style.display = "none";
            } else if (selectedValue === "3") {
                statusChart1.style.display = "none";
                statusChart2.style.display = "none";
                statusChart3.style.display = "block";
            }
        });
    </script>
@endsection

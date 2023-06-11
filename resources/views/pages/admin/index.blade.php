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
                </div>
            </div>

            <div class="card-body">
                <div class="chart-area">
                    <canvas id="typeChart"></canvas>
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

    <script src="{{ asset('assets/js/chart.min.js') }}"></script>

    <script>
        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        var chartData = @json($chartData);
        var ctx = document.getElementById("typeChart");
        var typeChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    </script>
@endsection

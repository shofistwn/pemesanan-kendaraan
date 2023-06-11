<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;

class ManagerController extends Controller
{

  public function index()
  {
    $bookings = Booking::with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->whereHas('approval', function ($query) {
        $query->where('user_id', auth()->user()->id);
      })
      ->orderByDesc('id')
      ->limit(5)
      ->get();

    $dataBookings = Booking::with('vehicle', 'approval')
      ->whereHas('approval', function ($query) {
        $query->where('user_id', auth()->user()->id);
      })
      ->orderByDesc('id')
      ->get();

    $bookingCounts = $dataBookings->groupBy(function ($booking) {
      $bookingDate = Carbon::parse($booking->booking_date);
      return $bookingDate->format('M, Y');
    })->map(function ($group) {
      return $group->groupBy('vehicle.vehicle_type')
        ->map(function ($group) {
          return $group->count();
        });
    });

    $monthLabels = [];
    $datasetByVehicleTypes = [];

    foreach ($bookingCounts as $month => $counts) {
      $monthLabels[] = $month;

      foreach ($counts as $vehicleType => $count) {
        if (!isset($datasetByVehicleTypes[$vehicleType])) {
          $datasetByVehicleTypes[$vehicleType] = [];
        }

        $datasetByVehicleTypes[$vehicleType][] = $count;
      }
    }

    $chartData = [
      'labels' => $monthLabels,
      'datasets' => [],
    ];

    $options = [
      [
        'lineTension' => 0.3,
        'backgroundColor' => "rgba(255, 140, 0, 0.05)",
        'borderColor' => "rgba(255, 140, 0, 1)",
        'pointRadius' => 3,
        'pointBackgroundColor' => "rgba(255, 140, 0, 1)",
        'pointBorderColor' => "rgba(255, 140, 0, 1)",
        'pointHoverRadius' => 3,
        'pointHoverBackgroundColor' => "rgba(255, 140, 0, 1)",
        'pointHoverBorderColor' => "rgba(255, 140, 0, 1)",
        'pointHitRadius' => 10,
        'pointBorderWidth' => 2,
      ],
      [
        'lineTension' => 0.3,
        'backgroundColor' => "rgba(139, 69, 19, 0.05)",
        'borderColor' => "rgba(139, 69, 19, 1)",
        'pointRadius' => 3,
        'pointBackgroundColor' => "rgba(139, 69, 19, 1)",
        'pointBorderColor' => "rgba(139, 69, 19, 1)",
        'pointHoverRadius' => 3,
        'pointHoverBackgroundColor' => "rgba(139, 69, 19, 1)",
        'pointHoverBorderColor' => "rgba(139, 69, 19, 1)",
        'pointHitRadius' => 10,
        'pointBorderWidth' => 2,
      ]
    ];

    $backgroundColors = [
      ["rgba(139, 69, 19, 0.05)"],
      ["rgba(255, 140, 0, 0.05)"],
    ];

    $colors = [
      ["rgba(139, 69, 19, 1)"],
      ["rgba(255, 140, 0, 1)"],
    ];

    $i = 0;
    foreach ($datasetByVehicleTypes as $vehicleType => $data) {
      $chartData['datasets'][] = [
        'label' => $vehicleType,
        'data' => $data,
        'lineTension' => 0.3,
        'backgroundColor' => $backgroundColors[$i],
        'borderColor' => $colors[$i],
        'pointRadius' => 3,
        'pointBackgroundColor' => $colors[$i],
        'pointBorderColor' => $colors[$i],
        'pointHoverRadius' => 3,
        'pointHoverBackgroundColor' => $colors[$i],
        'pointHoverBorderColor' => $colors[$i],
        'pointHitRadius' => 10,
        'pointBorderWidth' => 2,
      ];
      $i++;
    }

    return view('pages.user.index', compact('bookings', 'chartData'));
  }
}
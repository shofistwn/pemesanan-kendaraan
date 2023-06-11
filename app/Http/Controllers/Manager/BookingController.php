<?php

namespace App\Http\Controllers\Manager;

use App\Exports\BookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class BookingController extends Controller
{
  public function index()
  {
    $bookings = Booking::with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->whereHas('approval', function ($query) {
        $query->where('user_id', auth()->user()->id);
      })
      ->orderByDesc('id')
      ->get();

    return view('pages.user.bookings.index', compact('bookings'));
  }

  public function search(Request $request)
  {
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $type = $request->input('type');

    $query = Booking::with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->whereHas('approval', function ($query) {
        $query->where('user_id', auth()->user()->id);
      });

    if ($startDate && $endDate) {
      $query->whereBetween('booking_date', [$startDate, $endDate]);
    }

    if ($type) {
      $query->whereHas('vehicle', function ($q) use ($type) {
        $q->where('vehicle_type', $type);
      });
    }

    $bookings = $query->get();

    return view('pages.user.bookings.index', compact('bookings'));
  }

  public function show(int $booking_id)
  {
    $booking = Booking::where('id', $booking_id)
      ->with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->first();

    return view('pages.user.bookings.show', compact('booking'));
  }

  public function edit(int $booking_id)
  {
    $booking = Booking::where('id', $booking_id)
      ->with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->first();

    $drivers = Driver::orderBy('id')
      ->get();

    $vehicles = Vehicle::orderBy('id')
      ->select('id', 'vehicle_number')
      ->get();

    $firstApprovers = User::where('role', 'regional_manager')
      ->orderBy('id')
      ->select('id', 'name')
      ->get();

    $secondApprovers = User::where('role', 'branch_manager')
      ->orderBy('id')
      ->select('id', 'name')
      ->get();

    return view(
      'pages.user.bookings.edit',
      compact(
        'booking',
        'drivers',
        'vehicles',
        'firstApprovers',
        'secondApprovers'
      )
    );
  }

  public function update(Request $request, int $booking_id)
  {
    $booking = Booking::find($booking_id);

    $validator = Validator::make($request->all(), [
      'status' => 'string|required',
    ]);

    $requestData = $validator->validated();
    $user_id = auth()->user()->id;

    try {
      DB::beginTransaction();

      $booking->approval->firstWhere('user_id', $user_id)->update([
        'approval_status' => $requestData['status'],
      ]);

      DB::commit();

      return redirect()->route('user.bookings.index')->with('success', 'Successfully updated data');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error', $e->getMessage());
    }
  }


  public function delete(int $booking_id)
  {
    $booking = Booking::find($booking_id);

    try {
      DB::beginTransaction();

      $approvals = Approval::where('booking_id', $booking->id)->get();

      if ($approvals) {
        $approvals->each(function ($approval) {
          $approval->delete();
        });
      }

      $booking->delete();

      DB::commit();

      return redirect()->route('user.bookings.index')->with('success', 'Successfully deleted data');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error', $e->getMessage());
    }
  }

  public function export(Request $request)
  {
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $type = $request->input('type');

    $query = Booking::with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->whereHas('approval', function ($query) {
        $query->where('user_id', auth()->user()->id);
      });

    if ($startDate && $endDate) {
      $query->whereBetween('booking_date', [$startDate, $endDate]);
    }

    if ($type) {
      $query->whereHas('vehicle', function ($q) use ($type) {
        $q->where('vehicle_type', $type);
      });
    }

    $bookings = $query->get();

    $exportData = $bookings->map(function ($booking, $index) {
      $firstApprover = $booking->approval->get(0)->user->name ?? '-';
      $secondApprover = $booking->approval->get(1)->user->name ?? '-';

      $status = '-';
      if (!$booking->approval->isEmpty()) {
        if ($booking->approval->get(0)->approval_status == 'rejected' || $booking->approval->get(1)->approval_status == 'rejected') {
          $status = 'Rejected';
        } elseif ($booking->approval->get(0)->approval_status == 'pending') {
          $status = 'Pending Approver 1';
        } elseif ($booking->approval->get(1)->approval_status == 'approved') {
          $status = 'Approved';
        } elseif ($booking->approval->get(0)->approval_status == 'approved') {
          $status = 'Pending Approver 2';
        }
      }

      return [
        '#' => ++$index,
        'Driver' => $booking->driver->driver_name,
        'Vehicle Type' => $booking->vehicle->vehicle_type,
        'Vehicle Number' => $booking->vehicle->vehicle_number,
        'First Approver' => $firstApprover,
        'Second Approver' => $secondApprover,
        'Status' => $status,
        'Date' => $booking->booking_date,
      ];
    });

    return Excel::download(new BookingsExport($exportData), 'Bookings - Pemesanan Kendaraan.xlsx');
  }
}
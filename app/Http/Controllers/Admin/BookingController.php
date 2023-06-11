<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use DB;
use Illuminate\Http\Request;
use Validator;

class BookingController extends Controller
{
  public function index()
  {
    $bookings = Booking::with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->get();

    return view('pages.admin.bookings.index', compact('bookings'));
  }

  public function search(Request $request)
  {
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $type = $request->input('type');

    $query = Booking::with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role');

    if ($startDate && $endDate) {
      $query->whereBetween('booking_date', [$startDate, $endDate]);
    }

    if ($type) {
      $query->whereHas('vehicle', function ($q) use ($type) {
        $q->where('vehicle_type', $type);
      });
    }

    $bookings = $query->get();

    return view('pages.admin.bookings.index', compact('bookings'));
  }

  public function create()
  {
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
      'pages.admin.bookings.create',
      compact(
        'drivers',
        'vehicles',
        'firstApprovers',
        'secondApprovers'
      )
    );
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'driver_id' => 'integer',
      'vehicle_id' => 'integer',
      'first_approver_id' => 'integer',
      'second_approver_id' => 'integer',
    ]);

    $requestData = $validator->validated();

    try {
      DB::beginTransaction();

      $booking = Booking::create([
        'user_id' => auth()->user()->id,
        'driver_id' => $requestData['driver_id'],
        'vehicle_id' => $requestData['vehicle_id'],
        'booking_date' => now()
      ]);

      $booking_id = $booking->id;
      $first_approver = User::where('id', $requestData['first_approver_id'])
        ->select('id', 'role')
        ->first();

      $second_approver = User::where('id', $requestData['second_approver_id'])
        ->select('id', 'role')
        ->first();

      Approval::create([
        'booking_id' => $booking_id,
        'user_id' => $first_approver->id,
        'approval_level' => $first_approver->role === 'regional_manager' ? 1 : 2,
      ]);

      Approval::create([
        'booking_id' => $booking_id,
        'user_id' => $second_approver->id,
        'approval_level' => $second_approver->role === 'regional_manager' ? 1 : 2,
      ]);

      DB::commit();

      return redirect()->route('admin.bookings.index')->with('success', 'Successfully created data');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error', $e->getMessage());
    }
  }

  public function show(int $booking_id)
  {
    $booking = Booking::find($booking_id)
      ->with('user:id,name', 'vehicle', 'driver', 'approval.user:id,name,role')
      ->first();

    return view('pages.admin.bookings.show', compact('booking'));
  }

  public function edit(int $booking_id)
  {
    $booking = Booking::find($booking_id)
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
      'pages.admin.bookings.edit',
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
      'driver_id' => 'integer',
      'vehicle_id' => 'integer',
      'first_approver_id' => 'integer',
      'second_approver_id' => 'integer',
    ]);

    $requestData = $validator->validated();

    try {
      DB::beginTransaction();

      Approval::where('booking_id', $booking->id)
        ->where('user_id', $booking->approval->get(0)->user_id)
        ->first()
        ->update(['user_id', $requestData['first_approver_id']]);

      Approval::where('booking_id', $booking->id)
        ->where('user_id', $booking->approval->get(1)->user_id)
        ->first()
        ->update(['user_id', $requestData['second_approver_id']]);

      $booking->update($requestData);

      DB::commit();

      return redirect()->route('admin.bookings.index')->with('success', 'Successfully updated data');
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

      return redirect()->route('admin.bookings.index')->with('success', 'Successfully deleted data');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error', $e->getMessage());
    }
  }
}
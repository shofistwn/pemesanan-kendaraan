<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
  public function index()
  {
    return view('pages.admin.bookings.index');
  }
  
  public function create()
  {
    return view('pages.admin.bookings.create');
  }

  public function show()
  {
    return view('pages.admin.bookings.show');
  }

  public function edit()
  {
    return view('pages.admin.bookings.edit');
  }
}
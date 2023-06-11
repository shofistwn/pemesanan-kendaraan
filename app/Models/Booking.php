<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $guarded = [
    'id'
  ];

  public function getBookingDateAttribute($value)
  {
    return Carbon::parse($value)->format('d M, Y');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function vehicle()
  {
    return $this->belongsTo(Vehicle::class);
  }

  public function driver()
  {
    return $this->belongsTo(Driver::class);
  }

  public function approval()
  {
    return $this->hasMany(Approval::class);
  }
}
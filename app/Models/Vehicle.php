<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $guarded = [
    'id'
  ];

  public function getVehicleTypeAttribute($value)
  {
    if ($value === 'passenger') {
      return 'Passenger Vehicle';
    } elseif ($value === 'cargo') {
      return 'Cargo Vehicle';
    }

    return $value;
  }

  public function booking()
  {
    return $this->hasMany(Booking::class);
  }
}
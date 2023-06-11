<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
  use HasFactory;

  protected $guarded = [
    'id'
  ];

  public function booking()
  {
    return $this->belongsTo(Booking::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
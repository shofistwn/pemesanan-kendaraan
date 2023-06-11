<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
      'id'
    ];

    public function booking()
    {
      return $this->hasMany(Booking::class);
    }
}

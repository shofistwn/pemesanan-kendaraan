<?php

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('approvals', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Booking::class);
      $table->foreignIdFor(User::class);
      $table->enum('approval_level', [1, 2]);
      $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('approvals');
  }
};
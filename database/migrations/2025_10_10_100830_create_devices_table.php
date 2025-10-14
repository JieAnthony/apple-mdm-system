<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 50)->unique();
            $table->string('udid', 100)->unique();
            $table->string('name');
            $table->boolean('in_abm')->unsigned();
            $table->boolean('supervision')->unsigned();
            $table->boolean('activation_lock')->unsigned();
            $table->boolean('lost_mode')->unsigned();
            $table->timestamps();
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('last_active_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

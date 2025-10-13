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
        Schema::create('device_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id')->unique();
            $table->boolean('is_network_tethered')->unsigned()->nullable();
            $table->unsignedInteger('device_capacity')->nullable();
            $table->unsignedInteger('available_device_capacity')->nullable();
            $table->unsignedTinyInteger('battery_level')->nullable();
            $table->unsignedTinyInteger('cellular_technology')->nullable();
            $table->string('device_name')->nullable();
            $table->string('build_version')->nullable();
            $table->string('eas_device_identifier')->nullable();
            $table->string('model')->nullable();
            $table->string('model_name')->nullable();
            $table->string('model_number')->nullable();
            $table->string('modem_firmware_version')->nullable();
            $table->string('os_version')->nullable();
            $table->string('product_name')->nullable();
            $table->string('software_update_device_id')->nullable();
            $table->string('supplemental_build_version')->nullable();
            $table->string('wifi_mac')->nullable();
            $table->string('bluetooth_mac')->nullable();
            $table->json('service_subscriptions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_profiles');
    }
};

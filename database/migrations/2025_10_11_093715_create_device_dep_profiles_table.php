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
        Schema::create('device_dep_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id')->index();
            $table->char('uuid', 32)->nullable();
            $table->string('assigned_by_abm_account', 100)->nullable();
            $table->timestamps();
            $table->timestamp('device_assigned_at')->nullable();
            $table->timestamp('profile_assigned_at')->nullable();
            $table->timestamp('profile_pushed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_dep_profiles');
    }
};

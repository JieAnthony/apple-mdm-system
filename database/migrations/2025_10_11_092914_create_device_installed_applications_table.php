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
        Schema::create('device_installed_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->string('identifier', 100);
            $table->string('name');
            $table->string('version')->nullable();
            $table->string('short_version')->nullable();
            $table->boolean('ad_hoc_code_signed')->unsigned()->nullable();
            $table->boolean('app_store_vendable')->unsigned()->nullable();
            $table->boolean('beta_app')->unsigned()->nullable();
            $table->boolean('device_based_vpp')->unsigned()->nullable();
            $table->boolean('has_update_available')->unsigned()->nullable();
            $table->boolean('installing')->unsigned()->nullable();
            $table->boolean('is_app_clip')->unsigned()->nullable();
            $table->boolean('is_validated')->unsigned()->nullable();
            $table->unsignedBigInteger('bundle_size')->nullable();
            $table->unsignedBigInteger('dynamic_size')->nullable();
            $table->unsignedBigInteger('external_version_identifier')->nullable();
            $table->timestamps();
            $table->unique(['device_id', 'identifier']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_installed_applications');
    }
};

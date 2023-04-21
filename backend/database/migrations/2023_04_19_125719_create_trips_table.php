<?php

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class, 'driver_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->timestampTz('accepted_at')->nullable();
            $table->boolean('is_started')->default(false);
            $table->timestampTz('started_at')->nullable();
            $table->boolean('is_arrived')->default(false);
            $table->timestampTz('arrived_at')->nullable();
            $table->boolean('is_complete')->default(false);
            $table->timestampTz('complete_at')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->timestampTz('cancelled_at')->nullable();
            $table->point('origin')->nullable();
            $table->jsonb('origin_text')
                ->always()
                ->storedAs( "ST_AsGeoJSON(origin)")->nullable();
            $table->point('destination')->nullable();
            $table->jsonb('destination_text')
                ->always()
                ->storedAs( "ST_AsGeoJSON(destination)")->nullable();
            $table->point('driver_location')->nullable();
            $table->jsonb('driver_location_text')
                ->always()
                ->storedAs( "ST_AsGeoJSON(driver_location)")->nullable();
            $table->point('user_location')->nullable();
            $table->jsonb('user_location_text')
                ->always()
                ->storedAs( "ST_AsGeoJSON(user_location)")->nullable();
            $table->string('destination_name')->nullable();
            $table->string('start_code', 6)->nullable();
            $table->float('distance')->nullable();
            $table->float('cost')->nullable();
            $table->uuid('channel')->nullable();
            $table->softDeletesTz();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};

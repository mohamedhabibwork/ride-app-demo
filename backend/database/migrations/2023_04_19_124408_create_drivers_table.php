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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class,'user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedSmallInteger('year');
            $table->string('make');
            $table->string('model');
            $table->string('color');
            $table->string('license_plate');
            $table->boolean('status')->nullable();
            $table->float('balance')->default(0);
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};

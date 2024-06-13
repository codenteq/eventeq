<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_applications', function (Blueprint $table) {
            $table->id();
            $table->string('job');
            $table->integer('tent')->nullable();
            $table->integer('sleeping_bag')->nullable();
            $table->integer('mat')->nullable();
            $table->integer('chair')->nullable();
            $table->boolean('dont_camping_equipment');
            $table->integer('telescope');
            $table->string('telescope_brand')->nullable();
            $table->integer('swaddling');
            $table->string('swaddling_brand')->nullable();
            $table->integer('binocular');
            $table->integer('camera');
            $table->integer('tripod');
            $table->integer('walkie_talkie');
            $table->integer('computer');
            $table->date('arrival_date')->nullable();
            $table->date('departure_date');
            $table->date('check_in')->nullable();
            $table->foreignIdFor(\App\Models\Group::class)->nullable();
            $table->foreignIdFor(\App\Models\City::class);
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Event::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_applications');
    }
};

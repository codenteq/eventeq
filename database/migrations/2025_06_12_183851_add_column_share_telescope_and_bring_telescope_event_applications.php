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
        Schema::table('event_applications', function (Blueprint $table) {
            $table->boolean('share_telescope')->default(false);
            $table->boolean('bring_telescope')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_applications', function (Blueprint $table) {
            //
        });
    }
};

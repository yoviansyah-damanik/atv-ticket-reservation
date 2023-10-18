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
        Schema::create('unit_usages', function (Blueprint $table) {
            $table->char('reservation_id', 16)
                ->references('id')
                ->on('reservations')
                ->cascadeOnDelete();
            $table->char('unit_id', 9)
                ->references('id')
                ->on('units')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_usages');
    }
};

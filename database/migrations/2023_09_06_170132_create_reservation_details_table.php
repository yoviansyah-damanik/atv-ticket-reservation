<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->foreignUuid('reservation_id')
                ->references('id')
                ->on('reservations')
                ->cascadeOnDelete();
            $table->foreignId('unit_id')
                ->references('id')
                ->on('units')
                ->cascadeOnDelete()
                ->nullable();
            $table->foreignId('package_id')
                ->references('id')
                ->on('packages')
                ->cascadeOnDelete();
            $table->integer('amount');
            $table->double('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_details');
    }
};

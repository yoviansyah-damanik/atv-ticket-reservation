<?php

use App\Enums\ReservationType;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreignId('verifier_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->enum('status', ReservationType::getValues())
                ->default(ReservationType::WaitingForConfirmation);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

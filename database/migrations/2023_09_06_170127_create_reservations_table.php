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
            $table->char('id', 16)->primary();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->string('orderer_name');
            $table->foreignId('verifier_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('date');
            $table->time('time')->nullable();
            $table->enum('status', ReservationType::getValues())
                ->default(ReservationType::WaitingForPayment);
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

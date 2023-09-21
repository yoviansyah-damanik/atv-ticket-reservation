<?php

use App\Enums\PaymentType;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('reservation_id')
                ->references('id')
                ->on('reservations')
                ->cascadeOnDelete();
            $table->foreignId('payment_vendor_id')
                ->references('id')
                ->on('payment_vendors')
                ->cascadeOnDelete();
            $table->string('evidence')->nullable();
            $table->double('paid');
            $table->double('debt')->default(0);
            $table->enum('status', PaymentType::getValues())
                ->default(PaymentType::WaitingForConfirmation);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

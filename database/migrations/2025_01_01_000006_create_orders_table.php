<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('shipping_country');
            $table->string('shipping_state');
            $table->string('shipping_city');
            $table->string('shipping_address');
            $table->string('shipping_postal_code');
            $table->decimal('total', 12, 2);
            $table->foreignId('payment_method_id')->constrained();
            $table->string('payment_proof_path')->nullable();
            $table->string('status')->default('pending_verification');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('customer_email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

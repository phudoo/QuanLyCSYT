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
    Schema::create('orders', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('customer_name', 255);
        $table->string('customer_email', 255);
        $table->decimal('total_amount', 10, 2);
        $table->string('status', 50)->default('pending');
        $table->timestamps(); // Bao gồm 'created_at' và 'updated_at'
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_report_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('total_sold');
            $table->decimal('revenue', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->decimal('profit', 10, 2);
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reports');
    }
};

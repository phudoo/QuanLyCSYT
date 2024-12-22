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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // ID chi tiết đơn hàng
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Liên kết với bảng orders
            $table->integer('product_id'); // ID sản phẩm
            $table->string('product_name'); // Tên sản phẩm
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->decimal('unit_price', 10, 2); // Giá sản phẩm
            $table->decimal('total_price', 10, 2); // Tổng giá trị (quantity * unit_price)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

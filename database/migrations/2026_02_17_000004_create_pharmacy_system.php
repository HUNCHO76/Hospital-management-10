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
        Schema::create('medicine_manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('address')->nullable();
            $table->string('license_number')->nullable();
            $table->timestamps();
        });

        Schema::create('medicine_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('payment_terms')->nullable();
            $table->integer('delivery_days')->default(7);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->text('description')->nullable();
            $table->string('category');
            $table->foreignId('manufacturer_id')->nullable()->constrained('medicine_manufacturers')->onDelete('set null');
            $table->decimal('unit_price', 10, 2);
            $table->string('strength')->nullable();
            $table->string('route')->nullable(); // oral, injection, topical, etc.
            $table->boolean('is_controlled')->default(false);
            $table->boolean('requires_prescription')->default(false);
            $table->timestamps();
            $table->index('category');
            $table->index('name');
        });

        Schema::create('medicine_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->bigInteger('available_quantity')->default(0);
            $table->bigInteger('reserved_quantity')->default(0);
            $table->bigInteger('minimum_stock_level')->default(10);
            $table->bigInteger('maximum_stock_level')->default(1000);
            $table->bigInteger('reorder_quantity')->default(100);
            $table->timestamp('last_restocked_at')->nullable();
            $table->string('storage_location')->nullable();
            $table->timestamps();
            $table->unique('medicine_id');
            $table->index('available_quantity');
        });

        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->string('batch_number');
            $table->date('expiry_date');
            $table->date('manufacture_date')->nullable();
            $table->bigInteger('quantity_received');
            $table->bigInteger('quantity_available');
            $table->foreignId('supplier_id')->constrained('medicine_suppliers')->onDelete('restrict');
            $table->decimal('cost_price', 10, 2);
            $table->timestamp('received_at');
            $table->timestamps();
            $table->index('batch_number');
            $table->index('expiry_date');
            $table->index('medicine_id');
        });

        Schema::create('medicine_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('supplier_id')->constrained('medicine_suppliers')->onDelete('restrict');
            $table->timestamp('order_date');
            $table->date('expected_delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('status', ['pending', 'processing', 'delivered', 'cancelled'])->default('pending');
            $table->foreignId('ordered_by')->constrained('users')->onDelete('restrict');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('status');
            $table->index('order_date');
        });

        Schema::create('medicine_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_order_id')->constrained('medicine_orders')->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('restrict');
            $table->bigInteger('quantity');
            $table->bigInteger('received_quantity')->default(0);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->timestamps();
            $table->index('medicine_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_order_items');
        Schema::dropIfExists('medicine_orders');
        Schema::dropIfExists('medicine_batches');
        Schema::dropIfExists('medicine_inventories');
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('medicine_suppliers');
        Schema::dropIfExists('medicine_manufacturers');
    }
};

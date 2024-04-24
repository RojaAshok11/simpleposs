<?php

use App\Models\Admin\Product\Product;
use App\Models\Admin\Sale\Sale;
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
        Schema::create('saleitems', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Sale::class)->constrained('sales');

            $table->foreignIdFor(Product::class);

            $table->string('product_name');
            $table->decimal('purchaseprice', 10, 2);
            $table->decimal('sellingprice', 10, 2);
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->integer('return_quantity')->default(0);
            $table->integer('returnable_quantity')->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('grandtotal', 10, 2);

            $table->double('taxamt', 10, 2)->nullable();
            $table->double('taxable', 10, 2)->nullable();
            $table->double('cgst', 10, 2)->nullable();
            $table->double('cgstamt', 10, 2)->nullable();
            $table->double('sgst', 10, 2)->nullable();
            $table->double('sgstamt', 10, 2)->nullable();

            $table->double('vat', 10, 2)->nullable();
            $table->double('vatamt', 10, 2)->nullable();

            $table->string('note')->nullable();

            $table->uuid('uuid')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saleitems');
    }
};

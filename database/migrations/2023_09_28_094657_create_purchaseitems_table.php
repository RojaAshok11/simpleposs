<?php

use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchase\Purchase;
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
        Schema::create('purchaseitems', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Purchase::class)->constrained('purchases');

            $table->foreignIdFor(Product::class);
            $table->string('product_name');
            $table->double('purchaseprice', 10, 2)->nullable();
            $table->double('price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('return_quantity')->default(0);
            $table->integer('returnable_quantity')->default(0);
            $table->double('total', 10, 2)->nullable();

            $table->double('taxamt', 10, 2)->nullable();
            $table->double('taxable', 10, 2)->nullable();
            $table->double('cgst', 10, 2)->nullable();
            $table->double('cgstamt', 10, 2)->nullable();
            $table->double('sgst', 10, 2)->nullable();
            $table->double('sgstamt', 10, 2)->nullable();
            $table->double('igst', 10, 2)->nullable();
            $table->double('igstamt', 10, 2)->nullable();
            $table->double('cess', 10, 2)->nullable();
            $table->double('cessamt', 10, 2)->nullable();

            $table->double('vat', 10, 2)->nullable();
            $table->double('vatamt', 10, 2)->nullable();

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
        Schema::dropIfExists('purchaseitems');
    }
};

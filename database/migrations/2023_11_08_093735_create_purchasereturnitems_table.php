<?php

use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchasereturn\Purchasereturn;
use App\Models\Admin\Purchase\Purchaseitem;
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
        Schema::create('purchasereturnitems', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Purchaseitem::class);
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Purchasereturn::class);

            $table->string('return_quantity');

            $table->double('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasereturnitems');
    }
};

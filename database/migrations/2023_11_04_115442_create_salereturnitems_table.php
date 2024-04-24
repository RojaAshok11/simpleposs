<?php

use App\Models\Admin\Product\Product;
use App\Models\Admin\Salereturn\Salereturn;
use App\Models\Admin\Sale\Saleitem;
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
        Schema::create('salereturnitems', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Saleitem::class);
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Salereturn::class);

            $table->string('return_quantity');

            $table->double('total', 10, 2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salereturnitems');
    }
};

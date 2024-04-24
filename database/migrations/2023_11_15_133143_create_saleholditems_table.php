<?php

use App\Models\Admin\Product\Product;
use App\Models\Admin\Salehold\Salehold;
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
        Schema::create('saleholditems', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Salehold::class)->constrained('saleholds');

            $table->foreignIdFor(Product::class);

            $table->integer('quantity');

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
        Schema::dropIfExists('saleholditems');
    }
};

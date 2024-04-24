<?php

use App\Models\Admin\Auth\User;
use App\Models\Admin\Product\Product;
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
        Schema::create('stockcds', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('credit')->default(0);
            $table->bigInteger('debit')->default(0);
            $table->bigInteger('balance')->default(0);
            $table->boolean('is_adjustment', array(0, 1))->default(0);
            $table->char('c_or_d', 1); // C-Credit D-Debit
            $table->foreignIdFor(Product::class);
            $table->morphs('stockcdable');

            $table->foreignIdFor(User::class);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockcds');
    }
};

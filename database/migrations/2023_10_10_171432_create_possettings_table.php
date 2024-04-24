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
        Schema::create('possettings', function (Blueprint $table) {
            $table->id();

            $table->integer('theme')->nullable(); // 4 grid, 5 grid, 6 grid
            $table->integer('pos_position')->nullable(); //left, right

            $table->integer('date_format')->nullable();
            $table->integer('time_type')->nullable();

            $table->integer('currency')->nullable();
            $table->integer('timezone')->nullable();
            $table->string('carticon'); //pos items icon

            $table->integer('bar_code')->nullable(); //need to do later
            $table->integer('bill_type')->nullable(); //need to do later
            $table->integer('tax_type')->default(1); //need to do later
            $table->boolean('is_hold', array(0, 1))->default(0);
            $table->boolean('is_holdreference', array(0, 1))->default(0);
            $table->string('language')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('possettings');
    }
};
